<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
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
    public $attachment; // For file upload
    public $isMobile = false;

    public function mount()
    {
        $authId = Auth::id();
        
        // Load users: Admins, Managers AND anyone who has chat history with Auth user
        $this->users = User::where('id', '!=', $authId)
            ->where(function($query) use ($authId) {
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
            ->sortByDesc(fn($user) => $user->last_message?->created_at ?? $user->created_at)
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
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) {
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
            'content' => $this->attachment ? 'nullable|string' : 'required|string',
            'attachment' => 'nullable|file|max:10240', // Max 10MB
        ]);

        if (!$this->selectedUser) {
            return;
        }

        $attachmentPath = null;
        $attachmentType = null;

        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('chat-attachments', 'public');
            $mime = $this->attachment->getMimeType();
            
            if (str_contains($mime, 'image')) {
                $attachmentType = 'image';
            } elseif (str_contains($mime, 'video')) {
                $attachmentType = 'video';
            } else {
                $attachmentType = 'file';
            }
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'content' => $this->content ?? '',
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        // Send notification to receiver
        $this->selectedUser->notify(new \App\Notifications\MessageSent($message));

        // Broadcast the message
        broadcast(new MessageSent($message))->toOthers();

        // Add to local list immediately
        $this->chatMessages->push($message);
        
        // Reset inputs
        $this->content = '';
        $this->attachment = null;
        
        // Scroll to bottom dispatch
        $this->dispatch('scroll-to-bottom');
    }

    public function getListeners()
    {
        $authId = Auth::id();
        return [
            "echo-private:chat.{$authId},MessageSent" => 'receiveMessage',
        ];
    }

    public function receiveMessage($event)
    {
        $message = Message::find($event['message']['id']);

        // Check if sender is in the lists, if not, fetch and add
        $senderInList = $this->users->contains('id', $message->sender_id);
        
        if (!$senderInList) {
             $newUser = User::find($message->sender_id);
             if($newUser) {
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
                if (!$this->selectedUser || $this->selectedUser->id !== $user->id) {
                    $user->unread_count = ($user->unread_count ?? 0) + 1; // Ensure not null
                }
            }
            return $user;
        })->sortByDesc(fn($user) => $user->last_message?->created_at ?? $user->created_at)->values();
    }

    public function render()
    {
        return view('livewire.chat.chat-app');
    }
}
