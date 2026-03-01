<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;

    public $sender;

    public $messageContent;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $sender, string $messageContent)
    {
        $this->sender = $sender;
        $this->messageContent = $messageContent;
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
            'title' => 'Nova Mensagem',
            'description' => $this->sender->name.': '.\Illuminate\Support\Str::limit($this->messageContent, 30),
            'image' => $this->sender->profile_photo_url ?? $this->sender->avatar,
            'link' => route('chat.index'), // Link to chat
        ];
    }
}
