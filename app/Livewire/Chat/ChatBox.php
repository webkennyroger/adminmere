<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\ChatPreference;
use App\Models\Report;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatGroup;
use App\Models\GroupMessage;
use Livewire\WithFileUploads;
use App\Events\MessageSent;
use Livewire\Attributes\On;

class ChatBox extends Component
{
    use WithFileUploads;

    public $isMuted = false;
    public $isArchived = false;

    public function loadPreferences()
    {
        if ($this->selectedGroup) {
            $member = $this->selectedGroup->members()->where('user_id', Auth::id())->first();
            if ($member) {
                $this->isArchived = $member->pivot->is_archived;
                $this->isMuted = false;
            } else {
                $this->isArchived = false;
                $this->isMuted = false;
            }
            return;
        }

        if (!$this->selectedUser) return;

        $pref = ChatPreference::where('user_id', Auth::id())
            ->where('peer_id', $this->selectedUser->id)
            ->first();

        if ($pref) {
            $this->isMuted = $pref->is_muted;
            $this->isArchived = $pref->is_archived;
        } else {
            $this->isMuted = false;
            $this->isArchived = false;
        }
    }

    public function toggleMute()
    {
        if (!$this->selectedUser) return;

        $pref = ChatPreference::firstOrCreate(
            ['user_id' => Auth::id(), 'peer_id' => $this->selectedUser->id]
        );

        $pref->is_muted = !$pref->is_muted;
        $pref->save();

        $this->isMuted = $pref->is_muted;
    }

    public function toggleArchive()
    {
        if ($this->selectedGroup) {
            $member = $this->selectedGroup->members()->where('user_id', Auth::id())->first();
            if ($member) {
                $newState = !$member->pivot->is_archived;
                $this->selectedGroup->members()->updateExistingPivot(Auth::id(), [
                    'is_archived' => $newState
                ]);
                $this->isArchived = $newState;
            }
        } elseif ($this->selectedUser) {
            $pref = ChatPreference::firstOrCreate(
                ['user_id' => Auth::id(), 'peer_id' => $this->selectedUser->id]
            );

            $pref->is_archived = !$pref->is_archived;
            $pref->save();

            $this->isArchived = $pref->is_archived;
        } else {
            return;
        }

        $this->dispatch('refresh-chat-sidebar');

        if ($this->isArchived) {
            $this->closeChat();
        }
    }

    public function reportUser($reason = 'spam')
    {
        if (!$this->selectedUser) return;

        Report::create([
            'reporter_id' => Auth::id(),
            'reported_user_id' => $this->selectedUser->id,
            'reason' => $reason,
            'status' => 'pending'
        ]);

        $this->dispatch('notify', message: 'Usuário denunciado com sucesso.');
        $this->closeChat();
    }

    public function startVideoCall()
    {
        $this->dispatch('notify', message: 'Iniciando chamada de vídeo (Funcionalidade em breve)');
    }

    public function startAudioCall()
    {
        $this->dispatch('notify', message: 'Iniciando chamada de áudio (Funcionalidade em breve)');
    }

    public $isOpen = false;
    public $isMinimized = false;
    public $selectedUser;
    public $selectedGroup;
    public $chatMessages = [];
    public $content = '';
    public $attachments = [];
    public $audioAttachment;


    public function sendAudioMessage()
    {
        $this->validate([
            'audioAttachment' => 'required|file|mimes:mp3,wav,ogg,webm|max:10240',
        ]);

        if (!$this->selectedUser && !$this->selectedGroup) return;

        $path = $this->audioAttachment->store('chat-attachments', 'public');

        $attachmentsData[] = [
            'path' => $path,
            'mime_type' => $this->audioAttachment->getMimeType(),
            'name' => 'voice-message.webm',
            'size' => $this->audioAttachment->getSize(),
        ];

        if ($this->selectedGroup) {
            $message = GroupMessage::create([
                'chat_group_id' => $this->selectedGroup->id,
                'user_id' => Auth::id(),
                'content' => '',
                'attachments' => $attachmentsData,
            ]);
            $message->load('sender.profile');
            // broadcast(new GroupMessageSent($message))->toOthers();
            if (is_array($this->chatMessages)) {
                $this->chatMessages[] = $message;
            } else {
                $this->chatMessages->push($message);
            }
        } else {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->selectedUser->id,
                'content' => '',
                'attachments' => $attachmentsData,
            ]);
            broadcast(new MessageSent($message))->toOthers();
            if (is_array($this->chatMessages)) {
                $this->chatMessages[] = $message;
            } else {
                $this->chatMessages->push($message);
            }
        }

        $this->audioAttachment = null;
        $this->dispatch('scroll-chat-to-bottom');
        $this->dispatch('refresh-chat-sidebar');
    }


    public function mount()
    {
        if (session()->has('chat_isOpen') && session('chat_isOpen')) {
            $this->isOpen = true;
            $this->isMinimized = session('chat_isMinimized', false);

            $userId = session('chat_selectedUserId');
            if ($userId) {
                $this->selectedUser = User::find($userId);
                if ($this->selectedUser) {
                    $this->loadMessages();
                }
            }
        }
    }

    public function getListeners()
    {
        $authId = Auth::id();
        return [
            "echo-private:chat.{$authId},.message.sent" => 'receiveMessage',
            'open-chat-box' => 'openChat',
            'open-group-chat' => 'openGroup',
        ];
    }

    public function receiveMessage($event)
    {
        $messageData = $event['message'] ?? $event;
        if (!isset($messageData['id'])) return;

        $message = Message::find($messageData['id']);

        if ($message && $this->isOpen && $this->selectedUser && $this->selectedUser->id === $message->sender_id) {
            if (is_array($this->chatMessages)) {
                $this->chatMessages[] = $message;
            } else {
                $this->chatMessages->push($message);
            }
            $message->update(['read_at' => now()]);
            $this->dispatch('scroll-chat-to-bottom');
        }
    }

    public function openChat($userId)
    {
        $this->selectedGroup = null;
        $this->selectedUser = User::find($userId);
        $this->isOpen = true;
        $this->isMinimized = false;

        if ($this->selectedUser) {
            session([
                'chat_isOpen' => true,
                'chat_selectedUserId' => $this->selectedUser->id,
                'chat_isMinimized' => false
            ]);

            Message::where('sender_id', $this->selectedUser->id)
                ->where('receiver_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            $this->loadPreferences();
            $this->loadMessages();
        }

        $this->dispatch('scroll-chat-to-bottom');
    }

    public function openGroup($groupId)
    {
        $this->selectedUser = null;
        $this->isMinimized = false;

        $this->selectedGroup = ChatGroup::with('members.profile')->findOrFail($groupId);
        $this->loadMessages();

        $this->isOpen = true;

        session([
            'chat_isOpen' => true,
            'chat_selectedGroupId' => $groupId,
            'chat_selectedUserId' => null,
            'chat_isMinimized' => false
        ]);

        $this->loadPreferences();
        $this->dispatch('scroll-chat-to-bottom');
    }


    public function minimizeChat()
    {
        $this->isMinimized = !$this->isMinimized;
        session(['chat_isMinimized' => $this->isMinimized]);
    }

    public function closeChat()
    {
        $this->isOpen = false;
        $this->isMinimized = false;
        $this->selectedUser = null;
        $this->selectedGroup = null;
        $this->chatMessages = [];

        // Clear session state
        session()->forget(['chat_isOpen', 'chat_selectedUserId', 'chat_selectedGroupId', 'chat_isMinimized']);
    }

    public function loadMessages()
    {
        if ($this->selectedGroup) {
            $this->chatMessages = GroupMessage::with(['sender.profile'])
                ->where('chat_group_id', $this->selectedGroup->id)
                ->orderBy('created_at', 'asc')
                ->limit(100)
                ->get();
            return;
        }

        if (!$this->selectedUser) return;

        $authId = Auth::id();

        $this->chatMessages = Message::where(function ($query) use ($authId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $this->selectedUser->id)
                ->where('deleted_by_sender', false);
        })->orWhere(function ($query) use ($authId) {
            $query->where('sender_id', $this->selectedUser->id)
                ->where('receiver_id', $authId)
                ->where('deleted_by_receiver', false);
        })
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get();
    }

    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);

        if (!$message) return;

        $authId = Auth::id();

        if ($message->sender_id == $authId) {
            $message->deleted_by_sender = true;
        } elseif ($message->receiver_id == $authId) {
            $message->deleted_by_receiver = true;
        }

        $message->save();

        if ($message->deleted_by_sender && $message->deleted_by_receiver) {
            $message->delete();
        }

        $this->loadMessages();
    }

    public function deleteConversation()
    {
        if (!$this->selectedUser) return;

        $authId = Auth::id();

        // Messages where I am the sender -> mark deleted_by_sender
        Message::where('sender_id', $authId)
            ->where('receiver_id', $this->selectedUser->id)
            ->update(['deleted_by_sender' => true]);

        // Messages where I am the receiver -> mark deleted_by_receiver
        Message::where('sender_id', $this->selectedUser->id)
            ->where('receiver_id', $authId)
            ->update(['deleted_by_receiver' => true]);

        // Clean up messages deleted by both (Optional, but good for cleanup)
        Message::where('deleted_by_sender', true)
            ->where('deleted_by_receiver', true)
            ->delete();

        $this->chatMessages = [];
        $this->dispatch('close-chat'); // Or close chat window
        $this->closeChat();
    }

    public function markAsUnread()
    {
        if (!$this->selectedUser) return;

        $authId = Auth::id();

        // Find the last message sent by them to me
        $lastMessage = Message::where('sender_id', $this->selectedUser->id)
            ->where('receiver_id', $authId)
            ->latest()
            ->first();

        if ($lastMessage) {
            $lastMessage->update(['read_at' => null]);
        }

        $this->closeChat();
    }

    public function sendMessage()
    {
        $this->validate([
            'content' => count($this->attachments) > 0 ? 'nullable|string' : 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // Validate each file in the array
        ]);

        if (!$this->selectedUser && !$this->selectedGroup) return;

        $attachmentsData = [];

        if (!empty($this->attachments)) {
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

        if ($this->selectedGroup) {
            $message = GroupMessage::create([
                'chat_group_id' => $this->selectedGroup->id,
                'user_id' => Auth::id(),
                'content' => $this->content ?? '',
                'attachments' => !empty($attachmentsData) ? $attachmentsData : null,
            ]);

            // Reload to get relations like sender
            $message->load('sender.profile');

            // TODO: Broadcast GroupMessageSent event
            // broadcast(new GroupMessageSent($message))->toOthers();

            if (is_array($this->chatMessages)) {
                $this->chatMessages[] = $message;
            } else {
                $this->chatMessages->push($message);
            }
        } else {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->selectedUser->id,
                'content' => $this->content ?? '',
                'attachments' => !empty($attachmentsData) ? $attachmentsData : null,
            ]);

            // Broadcast
            broadcast(new MessageSent($message))->toOthers();

            if (is_array($this->chatMessages)) {
                $this->chatMessages[] = $message;
            } else {
                $this->chatMessages->push($message);
            }
        }

        $this->content = '';
        $this->attachments = [];

        $this->dispatch('scroll-chat-to-bottom');
        $this->dispatch('refresh-chat-sidebar');
    }

    public function formatFileSize($bytes, $precision = 1)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
