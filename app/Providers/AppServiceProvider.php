<?php

namespace App\Providers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);


        Gate::define('threadActionAuthorize', function (User $user, Thread $thread) {
            return $user->id === $thread->user_id;
        });
    }
}
