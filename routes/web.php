<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Thread;
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
});

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Admin Users - routes for create and edit forms only
    Route::get('/admin/user/create', [UserController::class, 'create'])->name('users.create');
    // Alias to support plural URL as well
    Route::get('/admin/users/create', [UserController::class, 'create']);
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/{user}/update', [UserController::class, 'update'])->name('users.update');
});

require __DIR__ . '/auth.php';
