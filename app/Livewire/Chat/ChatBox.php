<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Events\MessageSent;
use Livewire\Attributes\On;

class ChatBox extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $isMinimized = false;
    public $selectedUser;
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
            "echo-private:chat.{$authId},MessageSent" => 'receiveMessage',
            'open-chat-box' => 'openChat',
        ];
    }

    public function openChat($userId)
    {
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
            
            $this->loadMessages();
        }
        
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
        $this->chatMessages = [];
        
        // Clear session state
        session()->forget(['chat_isOpen', 'chat_selectedUserId', 'chat_isMinimized']);
    }

    public function loadMessages()
    {
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

        if (!$this->selectedUser) return;

        $attachmentPath = null;
        $attachmentType = null;

        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('chat-attachments', 'public');
            $mime = $this->attachment->getMimeType();
            $attachmentType = str_contains($mime, 'image') ? 'image' : (str_contains($mime, 'video') ? 'video' : 'file');
        }

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
        $this->content = '';
        $this->attachment = null;
        
        $this->dispatch('scroll-chat-to-bottom');
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
