<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Thread;
use App\Notifications\ActivityNotification;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ThreadController::class, 'index'])->name('home');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::get('/new-thread', [ThreadController::class, 'create'])->name("threads.create");
Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
Route::put('/threads/{thread}/update', [ThreadController::class, 'update'])->name('threads.update');
Route::post('/threads', [ThreadController::class, 'store']);
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

Route::post('/threads/{thread}/comments/store', [CommentController::class, 'store'])->middleware('auth');
Route::put('/comments/{comment}/update', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}/destroy', [CommentController::class, 'destroy'])->middleware('auth');

Route::post('/handle-follow/{user}', [FollowController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // notifications for ajax api route
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read_all');
});

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__ . '/auth.php';