<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Models\Thread;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ThreadController::class, 'index'])->name('home');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::get('/new-thread', [ThreadController::class, 'create']);
Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
Route::put('/threads/{thread}/update', [ThreadController::class, 'update'])->name('threads.update');
Route::post('/threads', [ThreadController::class, 'store']);
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
