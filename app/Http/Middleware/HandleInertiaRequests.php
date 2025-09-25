<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Tag;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'notifications' => $request->user() ? NotificationUtility::getNotifications( $request->user()) : collect(),
            'unread_count' => $request->user() ? $request->user()->unreadNotifications->count() : 0,
        ];
    }
}
