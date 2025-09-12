<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Comment;

class AdminController extends Controller
{
    public function index()
    {
        $latestThreads = Thread::with('user', 'category')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $latestUsers = User::orderByDesc('created_at')
            ->take(10)
            ->get();

        $userCount = User::count();
        $threadCount = Thread::count();
        $categoryCount = Category::count();
        $commentCount = Comment::count();

        return inertia("Admin/Dashboard", [
            'stats' => [
                'users' => $userCount,
                'threads' => $threadCount,
                'categories' => $categoryCount,
                'comments' => $commentCount,
            ],
            'latestThreads' => $latestThreads,
            'latestUsers' => $latestUsers,
        ]);
    }
}
