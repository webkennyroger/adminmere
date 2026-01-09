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
    public $attachment;

    protected $listeners = [
        'open-chat-box' => 'openChat',
    ];

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

    public function openChat($userId)
    {
        $this->selectedGroup = null;
        $this->selectedUser = User::find($userId);
        $this->isOpen = true;
        // If it's a new user or explicitly opening, unminimize unless previously minimized for same user? 
        // Logic: Open chat should show the chat.
        $this->isMinimized = false;
        
        if ($this->selectedUser) {
            // Persist state
            session([
                'chat_isOpen' => true,
                'chat_selectedUserId' => $this->selectedUser->id,
                'chat_isMinimized' => false
            ]);

            // Mark messages as read
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

        // Load Messages
        $this->loadMessages();

        // Dispatch
        $this->isOpen = true;
        
        // Persist session
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
            'content' => $this->attachment ? 'nullable|string' : 'required|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        if (!$this->selectedUser && !$this->selectedGroup) return;

        $attachmentPath = null;
        $attachmentType = null;

        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('chat-attachments', 'public');
            $mime = $this->attachment->getMimeType();
            $attachmentType = str_contains($mime, 'image') ? 'image' : (str_contains($mime, 'video') ? 'video' : 'file');
        }

        if ($this->selectedGroup) {
            $message = GroupMessage::create([
                'chat_group_id' => $this->selectedGroup->id,
                'user_id' => Auth::id(),
                'content' => $this->content ?? '',
                'attachment' => $attachmentPath,
                'attachment_type' => $attachmentType,
            ]);
            
            // Reload to get relations like sender
            $message->load('sender.profile');
            
            // TODO: Broadcast GroupMessageSent event
            // broadcast(new GroupMessageSent($message))->toOthers();

            $this->chatMessages->push($message);
        } else {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->selectedUser->id,
                'content' => $this->content ?? '',
                'attachment_path' => $attachmentPath,
                'attachment_type' => $attachmentType,
            ]);

            // Broadcast
            broadcast(new MessageSent($message))->toOthers();

            $this->chatMessages->push($message);
        }

        $this->content = '';
        $this->attachment = null;
        
        $this->dispatch('scroll-chat-to-bottom');
        $this->dispatch('refresh-chat-sidebar');
    }

    public function receiveMessage($event)
    {
        $message = Message::find($event['message']['id']);

        if ($this->isOpen && $this->selectedUser && $this->selectedUser->id === $message->sender_id) {
            $this->chatMessages->push($message);
            $message->update(['read_at' => now()]);
            $this->dispatch('scroll-chat-to-bottom');
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
