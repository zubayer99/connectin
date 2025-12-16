<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewConnectionRequest extends Notification
{
    use Queueable;

    public $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
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
            'message' => $this->sender->name . ' sent you a connection request.',
            'link' => route('network.index'),
            'sender_id' => $this->sender->id,
            'avatar_path' => $this->sender->profile?->avatar_path,
        ];
    }
}
