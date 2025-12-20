<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class NotificationDropdown extends Component
{
    public $activeTab = 'all';
    public $isOpen = false;

    // Listeners for real-time updates (optional, if using broadcasting in future)
    // protected $listeners = ['notificationReceived' => '$refresh']; 

    public function mount()
    {
        //
    }

    public function getNotificationsProperty()
    {
        // Fetch unread notifications or all notifications depending on requirement.
        // Usually dropdown shows recent notifications.
        return auth()->user()->notifications()->latest()->take(20)->get(); 
    }

    public function getFilteredNotificationsProperty()
    {
        $all = $this->notifications;

        if ($this->activeTab === 'all') {
            return $all;
        }

        return $all->filter(function ($notification) {
            return isset($notification->data['type_key']) && $notification->data['type_key'] === $this->activeTab;
        });
    }

    public function getUnreadCountProperty()
    {
        return auth()->user()->unreadNotifications()->count();
    }

    /**
     * Get notification status for badge color
     * Returns: 'new' (orange), 'responded' (green), 'empty' (gray)
     */
    public function getNotificationStatusProperty()
    {
        $user = auth()->user();
        
        // Check for unread notifications
        $unreadCount = $user->unreadNotifications()->count();
        
        if ($unreadCount > 0) {
            return 'new'; // Orange - has unread notifications
        }
        
        // Check if user has any notifications at all
        $hasNotifications = $user->notifications()->exists();
        
        if (!$hasNotifications) {
            return 'empty'; // Gray - no notifications
        }
        
        // If has notifications but all are read
        return 'responded'; // Green - all responded/read
    }

    /**
     * Get badge color class based on notification status
     */
    public function getBadgeColorProperty()
    {
        return match($this->notificationStatus) {
            'new' => 'bg-orange-500',
            'responded' => 'bg-green-500',
            'empty' => 'bg-gray-400',
            default => 'bg-gray-400'
        };
    }

    public function markAsRead()
    {
        // When opening dropdown, maybe mark as read? Or keep them unread until archived?
        // For now, let's keep them as is until user interacts or archives.
    }

    public function archiveAll()
    {
        if ($this->activeTab === 'all') {
            auth()->user()->notifications()->delete();
        } else {
            // Delete only interactions of this type
            // Since we can't easily query by JSON key in delete() without raw query in some DBs,
            // we iterate and delete.
            $this->filteredNotifications->each(function($n) {
                $n->delete();
            });
        }
        
        $this->dispatch('notifications-updated'); // Optional hint
    }

    public function archiveItem($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
        
        // Optional: Mark all as read when opening? 
        // if ($this->isOpen) { auth()->user()->unreadNotifications->markAsRead(); }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.layouts.header.notification-dropdown');
    }
}
