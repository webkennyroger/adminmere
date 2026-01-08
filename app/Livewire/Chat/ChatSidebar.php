<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatSidebar extends Component
{
    public $users;

    public function getListeners()
    {
        $authId = Auth::id();
        return [
            "echo-private:chat.{$authId},MessageSent" => 'updateList',
        ];
    }
    
    public function mount()
    {
        $this->loadUsers();
    }

    public function updateList($event)
    {
        // Simply reload the user list to show new messages/unread counts
        $this->loadUsers();
    }

    public function loadUsers()
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
            ->values();
    }

    public function openChat($userId)
    {
        // Dispatch event to open the chat box
        $this->dispatch('open-chat-box', userId: $userId);
        
        // On mobile/small screen, we might want to close the sidebar?
        // For now, let's just dispatch.
    }

    public function render()
    {
        return view('livewire.chat.chat-sidebar');
    }
}
