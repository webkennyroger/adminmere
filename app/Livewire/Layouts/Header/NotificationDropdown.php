<?php

namespace App\Livewire\Layouts\Header;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\DatabaseNotification;

class NotificationDropdown extends Component
{
    public $isOpen = false;
    public $activeTab = 'all';

    public function getListeners()
    {
        return [
            'echo-private:App.Models.User.' . Auth::id() . ',.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated' => 'broadcastNotificationReceived',
            'refreshNotifications' => '$refresh',
        ];
    }

    public function broadcastNotificationReceived($event)
    {
        $this->dispatch('refreshNotifications');
    }

    public function getUnreadCountProperty()
    {
        return Auth::check() ? Auth::user()->unreadNotifications()->count() : 0;
    }

    public function getFilteredNotificationsProperty()
    {
        if (!Auth::check()) {
            return collect();
        }

        $query = Auth::user()->unreadNotifications();

        if ($this->activeTab !== 'all') {
            switch ($this->activeTab) {
                case 'message':
                    $query->where('type', 'App\Notifications\MessageSent'); 
                    // Adjust Notification Class Name as per your project
                    break;
                case 'challenges':
                    $query->where('type', 'App\Notifications\ChallengeCreated');
                    break;
                case 'tickets':
                    $query->where('type', 'App\Notifications\TicketCreated');
                    break;
                case 'registers':
                    $query->where('type', 'App\Notifications\UserRegistered');
                    break;
                case 'security':
                    $query->where('type', 'App\Notifications\SecurityAlert');
                     // Adjust Notification Class Name as per your project
                    break;
            }
        }

        return $query->latest()->take(10)->get()->map(function ($notification) {
            // Transform notification data for simpler view logic if needed
            return $notification;
        });
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->dispatch('refreshNotifications');
        }
    }
    
    public function archiveItem($notificationId)
    {
         $this->markAsRead($notificationId);
    }

    public function archiveAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('refreshNotifications');
    }

    public function render()
    {
        return view('livewire.layouts.header.notification-dropdown');
    }
}
