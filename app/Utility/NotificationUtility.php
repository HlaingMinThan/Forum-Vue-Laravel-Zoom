<?php
namespace App\Utility;

use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use App\Notifications\ActivityNotification;

trait  NotificationUtility{


    // for noti data
    private static function mapNotification($noti): array
    {
        return [
            'id' => $noti->id,
            'type' => $noti->data['type'] ?? null,
            'thread_id' => $noti->data['thread_id'] ?? null,
            'comment_id' => $noti->data['comment_id'] ?? null,
            'thread_title' => $noti->data['thread_title'] ?? null,
            'comment_user' => $noti->data['comment_user'] ?? null,
            'comment_body' => $noti->data['comment_body'] ?? null,
            'liked_user' => $noti->data['liked_user'] ?? null,
            'read_at' => $noti->read_at,
            'created_at' => $noti->created_at?->diffForHumans(),
        ];
    }

    public static function getNotifications(User $user){
            // dd($user->notifications);
            $notifications = $user?->load('notifications')->notifications
            ->sortByDesc('created_at')
            ->take(5)
            ->map(fn ($noti) =>
                self::mapNotification($noti)
            )->toArray();
            // dd($notifications);
            return  $notifications;
    }

    public  function getNotificationsPage(User $user,  $perPage = 5 , $page = null)
    {
        $query = $user->load('notifications')->notifications()->latest();
        $paginator = is_null($page)
            ? $query->paginate($perPage)
            : $query->paginate($perPage, ['*'], 'page', $page);

        $data = collect($paginator->items())
            ->map(fn ($noti) => self::mapNotification($noti))->values();

        return [
            'data' => $data,
            'current_page' => $paginator->currentPage(),
            'has_more' => $paginator->hasMorePages(),
        ];
    }


    // for send noti for comment
    public  function sendCommentNotification(Thread $thread, Comment $comment)
    {
        if ($thread->user_id === $comment->user_id) {
            // owner commented on their own thread → skip
            return;
        }

        $notification = (new ActivityNotification(
            'comment',
            $thread,
            $comment->user,
            $comment
        ))->onQueue('emails');

        
        $thread->user->notify($notification);
        
    }

    // for send noti for like
      public  function sendLikeNotification(Thread $thread, $liker)
    {
        if ($thread->user_id === $liker->id) {
            // owner liked their own thread → skip
            return;
        }

        $notification = (new ActivityNotification(
            'like',
            $thread,
            $liker
        ))->onQueue('emails');
        
        $thread->user->notify($notification);
        
    }

}