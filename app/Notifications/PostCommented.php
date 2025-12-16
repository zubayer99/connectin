<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostCommented extends Notification
{
    use Queueable;

    public $commenter;
    public $post;

    /**
     * Create a new notification instance.
     */
    public function __construct($commenter, $post)
    {
        $this->commenter = $commenter;
        $this->post = $post;
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
            'message' => $this->commenter->name . ' commented on your post.',
            'link' => route('dashboard'),
            'sender_id' => $this->commenter->id,
            'avatar_path' => $this->commenter->profile?->avatar_path,
        ];
    }
}
