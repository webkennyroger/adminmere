<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class ChatApp extends Component
{
    use WithFileUploads;

    public $users;

    public $selectedUser;

    public $chatMessages = [];

    public $content = '';

    public $attachments = []; // Multiple files

    public $audioAttachment;

    public $isMobile = false;

    public function mount()
    {
        $authId = Auth::id();

        // Load users: Admins, Managers AND anyone who has chat history with Auth user
        $this->users = User::where('id', '!=', $authId)
            ->where(function ($query) use ($authId) {
                // User has role admin/manager
                $query->whereHas('profile', function ($q) {
                    $q->whereIn('role', ['admin', 'manager']);
                })
                // OR user has messages with me (sent or received)
                    ->orWhereHas('messagesSent', function ($q) use ($authId) {
                        $q->where('receiver_id', $authId);
                    })
                    ->orWhereHas('messagesReceived', function ($q) use ($authId) {
                        $q->where('sender_id', $authId);
                    });
            })
            ->get()
            ->map(function ($user) use ($authId) {
                $user->last_message = Message::where(function ($q) use ($user, $authId) {
                    $q->where('sender_id', $authId)->where('receiver_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user, $authId) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $authId);
                    })
                    ->latest()
                    ->first();

                $user->unread_count = Message::where('sender_id', $user->id)
                    ->where('receiver_id', $authId)
                    ->whereNull('read_at')
                    ->count();

                return $user;
            })
            ->sortByDesc(fn ($user) => $user->last_message?->created_at ?? $user->created_at)
            ->values(); // Reset keys after sort
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);

        // Mark messages as read
        if ($this->selectedUser) {
            Message::where('sender_id', $this->selectedUser->id)
                ->where('receiver_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        $this->loadMessages();
        $this->dispatch('close-sidebar');
        $this->dispatch('scroll-to-bottom');
    }

    public function loadMessages()
    {
        if (! $this->selectedUser) {
            $this->chatMessages = [];

            return;
        }

        $this->chatMessages = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $this->selectedUser->id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->selectedUser->id)
                ->where('receiver_id', Auth::id());
        })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'content' => count($this->attachments) > 0 ? 'nullable|string' : 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // Max 10MB
        ]);

        if (! $this->selectedUser) {
            return;
        }

        $attachmentsData = [];

        if (! empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $path = $attachment->store('chat-attachments', 'public');
                $attachmentsData[] = [
                    'path' => $path,
                    'mime_type' => $attachment->getMimeType(),
                    'name' => $attachment->getClientOriginalName(),
                    'size' => $attachment->getSize(),
                ];
            }
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'content' => $this->content ?? '',
            'attachments' => ! empty($attachmentsData) ? $attachmentsData : null,
        ]);

        // Send notification to receiver
        $this->selectedUser->notify(new \App\Notifications\NewMessage(Auth::user(), $message->content));

        // Broadcast the message
        broadcast(new MessageSent($message))->toOthers();

        // Add to local list immediately
        $this->chatMessages->push($message);

        // Reset inputs
        $this->content = '';
        $this->attachments = [];

        // Scroll to bottom dispatch
        $this->dispatch('scroll-to-bottom');
    }

    public function sendAudioMessage()
    {
        $this->validate([
            'audioAttachment' => 'required|file|mimes:mp3,wav,ogg,webm|max:10240',
        ]);

        if (! $this->selectedUser) {
            return;
        }

        $path = $this->audioAttachment->store('chat-attachments', 'public');

        $attachmentsData[] = [
            'path' => $path,
            'mime_type' => $this->audioAttachment->getMimeType(),
            'name' => 'voice-message.webm',
            'size' => $this->audioAttachment->getSize(),
        ];

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'content' => '',
            'attachments' => $attachmentsData,
        ]);

        broadcast(new MessageSent($message))->toOthers();
        $this->chatMessages->push($message);

        $this->audioAttachment = null;
        $this->dispatch('scroll-to-bottom');

        // Refresh sidebar for last message
        $this->mount();
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function getListeners()
    {
        $authId = Auth::id();

        return [
            "echo-private:chat.{$authId},.message.sent" => 'receiveMessage',
        ];
    }

    public function receiveMessage($event)
    {
        $message = Message::find($event['message']['id']);

        // Check if sender is in the lists, if not, fetch and add
        $senderInList = $this->users->contains('id', $message->sender_id);

        if (! $senderInList) {
            $newUser = User::find($message->sender_id);
            if ($newUser) {
                $newUser->last_message = $message;
                $newUser->unread_count = 1;
                $this->users->prepend($newUser);
            }
        }

        // Update active conversation if applicable
        if ($this->selectedUser && $message->sender_id === $this->selectedUser->id) {
            $this->chatMessages->push($message);

            // Mark as read immediately if window is open
            $message->update(['read_at' => now()]);

            $this->dispatch('scroll-to-bottom');
        }

        // Update Sidebar List (Last Message & Unread Count)
        $this->users = $this->users->map(function ($user) use ($message) {
            if ($user->id === $message->sender_id) {
                $user->last_message = $message;
                if (! $this->selectedUser || $this->selectedUser->id !== $user->id) {
                    $user->unread_count = ($user->unread_count ?? 0) + 1; // Ensure not null
                }
            }

            return $user;
        })->sortByDesc(fn ($user) => $user->last_message?->created_at ?? $user->created_at)->values();
    }

    public function formatFileSize($bytes, $precision = 1)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }

    public function render()
    {
        return view('livewire.chat.chat-app');
    }
}
