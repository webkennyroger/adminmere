<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistered extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type_key' => 'registers',
            'title' => 'Novo Usuário Cadastrado',
            'description' => $this->user->name . ' (' . $this->user->email . ')',
            'time' => now(),
            'image' => null, // Could add avatar if available
            'icon_bg' => 'bg-green-100 dark:bg-green-500/20',
            'icon_color' => 'text-green-600 dark:text-green-400',
            // User Plus Icon
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3.75 15c0-2.342 2.686-5.188 7.5-5.188 4.28 0 6.64 2.235 7.172 4.384.05.204.075.412.075.617v1.937c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.375V15Z" /></svg>'
        ];
    }
}
