<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\ChatPreference;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

use App\Models\ChatGroup;

// Class start
class ChatSidebar extends Component
{
    public $users;
    public $groups; // List of groups

    public $showArchived = false;
    public $search = '';

    // Create Group Modal State
    public $showCreateGroupModal = false;
    public $newGroupName = '';
    public $selectedUsersForGroup = [];

    // New Chat Modal State
    public $showNewChatModal = false;
    public $searchUser = '';
    public $filteredUsers = [];

    protected $rules = [
        'newGroupName' => 'required|min:3',
        'selectedUsersForGroup' => 'required|array|min:1',
    ];

    public function getListeners()
    {
        $authId = Auth::id();
        return [
            "echo-private:chat.{$authId},.message.sent" => 'updateList',
            'refresh-chat-sidebar' => 'updateList',
        ];
    }

    public function mount()
    {
        $this->loadUsers();
        $this->loadGroups();
        $this->filteredUsers = collect();
    }

    public function updateList($event = null)
    {
        // Simply reload the user list to show new messages/unread counts
        $this->loadUsers();
        $this->loadGroups(); // Reload groups to update last message content if applicable later
    }

    public function toggleUserArchive($userId)
    {
        $pref = ChatPreference::firstOrCreate(
            ['user_id' => Auth::id(), 'peer_id' => $userId]
        );

        $pref->is_archived = !$pref->is_archived;
        $pref->save();

        $this->loadUsers();
    }

    public function toggleArchived()
    {
        $this->showArchived = !$this->showArchived;
        $this->loadUsers();
        $this->loadGroups();
    }

    public function openGroup($id)
    {
        $this->dispatch('open-group-chat', groupId: $id);
    }

    public function openCreateGroupModal()
    {
        $this->reset(['newGroupName', 'selectedUsersForGroup']);
        $this->showCreateGroupModal = true;
    }

    public function openNewChatModal()
    {
        $this->reset(['searchUser']);
        $this->updateFilteredUsers();
        $this->showNewChatModal = true;
    }

    public function updatedSearchUser()
    {
        $this->updateFilteredUsers();
    }

    public function updatedSearch()
    {
        $this->loadUsers();
    }

    public function updateFilteredUsers()
    {
        $authId = Auth::id();
        $this->filteredUsers = User::where('id', '!=', $authId)
            ->where('name', 'like', '%' . $this->searchUser . '%')
            ->limit(10)
            ->get();
    }

    public function startChat($userId)
    {
        $this->showNewChatModal = false;
        $this->dispatch('open-chat-box', userId: $userId);
    }

    public function createGroup()
    {
        $this->validate();

        // Create Group
        $group = ChatGroup::create([
            'name' => $this->newGroupName,
            // 'image' => ... (optional dynamic image not implemented yet)
        ]);

        // Attach Creator (Admin)
        $group->members()->attach(Auth::id(), ['role' => 'admin']);

        // Attach Selected Members
        $group->members()->attach($this->selectedUsersForGroup);

        // Reset and Refresh
        $this->showCreateGroupModal = false;
        $this->loadGroups();

        // Open the newly created group
        $this->openGroup($group->id);
    }

    public function toggleGroupArchive($groupId)
    {
        $group = ChatGroup::find($groupId);
        if ($group) {
            $member = $group->members()->where('user_id', Auth::id())->first();
            if ($member) {
                $group->members()->updateExistingPivot(Auth::id(), [
                    'is_archived' => !$member->pivot->is_archived
                ]);
                $this->loadGroups();
            }
        }
    }

    public function loadGroups()
    {
        // Load groups where the user is a member AND respects archive status
        $this->groups = ChatGroup::whereHas('members', function ($q) {
            $q->where('user_id', Auth::id())
                ->where('is_archived', $this->showArchived);
        })
            ->with(['members'])
            ->get()
            ->map(function ($group) {
                // Get the pivot for the auth user
                $authMember = $group->members->find(Auth::id());

                // Get Last Message
                $lastMsg = \App\Models\GroupMessage::where('chat_group_id', $group->id)->latest()->first();

                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'image' => $group->image ?? "https://ui-avatars.com/api/?name=" . urlencode($group->name),
                    'count' => $group->members->count(),
                    'members' => $group->members->map(fn($m) => [
                        'id' => $m->id,
                        'image' => $m->profile?->image ? \Illuminate\Support\Facades\Storage::url($m->profile->image) : $m->image_url
                    ])->toArray(),

                    'time' => $lastMsg ? $lastMsg->created_at->format('H:i') : '',
                    'msg' => $lastMsg ? $lastMsg->content : 'Grupo criado',
                    'is_archived' => $authMember ? $authMember->pivot->is_archived : false,
                ];
            });
    }

    // Cleaned up block

    public function loadUsers()
    {
        $authId = Auth::id();
        $authUser = User::find($authId);

        // IDs dos usuários que sigo
        $followingIds = $authUser->following()->pluck('users.id')->toArray();

        // Carregar usuários: admins, managers, histórico de chat OU que sigo
        $this->users = User::where('id', '!=', $authId)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($authId, $followingIds) {
                $query->whereHas('profile', function ($q) {
                    $q->whereIn('role', ['admin', 'manager']);
                })
                    ->orWhereHas('messagesSent', function ($q) use ($authId) {
                        $q->where('receiver_id', $authId);
                    })
                    ->orWhereHas('messagesReceived', function ($q) use ($authId) {
                        $q->where('sender_id', $authId);
                    })
                    // Inclui todos que sigo
                    ->orWhereIn('id', $followingIds);
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
                $pref = ChatPreference::where('user_id', $authId)->where('peer_id', $user->id)->first();
                $user->is_archived = $pref ? $pref->is_archived : false;
                return $user;
            })
            ->filter(function ($user) {
                return $this->showArchived ? $user->is_archived : !$user->is_archived;
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
