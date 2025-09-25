<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Utility\NotificationUtility;

class NotificationController extends Controller
{
    use NotificationUtility;
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = (int) ($request->get('perPage', 10));
        $page = $request->has('page') ? (int) $request->get('page') : null;

        $payload = $this->getNotificationsPage($user, $perPage, $page);

        return response()->json($payload + [
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markRead(DatabaseNotification $notification)
    {
        $user = Auth::user();
        abort_unless($notification->notifiable_id === $user->id && $notification->notifiable_type === get_class($user), 403);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'ok']);
    }

    public function markAllRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return response()->json(['status' => 'ok']);
    }
}


