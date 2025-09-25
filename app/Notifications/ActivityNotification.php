<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $thread;
    protected $user;
    protected $comment;
    /**
     * Create a new notification instance.
     */
    public function __construct($type, $thread, $user, $comment = null)
    {
        $this->type = $type; // 'comment' or 'like'
        $this->thread = $thread;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = new MailMessage;

        if ($this->type === 'comment') {
            $mail->subject("New comment on your thread: {$this->thread->title}")
                ->line("{$this->user->name} commented:")
                ->line($this->comment->body)
                ->action('View Comment', url("/threads/{$this->thread->id}#comment-{$this->comment->id}"));
        }

        if ($this->type === 'like') {
            $mail->subject("Your thread got a new like!")
                ->line("{$this->user->name} liked your thread: {$this->thread->title}")
                ->action('View Thread', url("/threads/{$this->thread->id}"));
        }

        return $mail->line('Thank you for using our forum!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($this->type === 'comment') {
            return [
                'type' => 'comment',
                'thread_id' => $this->thread->id,
                'thread_title' => $this->thread->title,
                'comment_id' => $this->comment->id,
                'comment_user' => $this->user->name,
                'comment_body' => $this->comment->body,
            ];
        }

        if ($this->type === 'like') {
            return [
                'type' => 'like',
                'thread_id' => $this->thread->id,
                'thread_title' => $this->thread->title,
                'liked_user' => $this->user->name,
            ];
        }

        return [];
    }
}
