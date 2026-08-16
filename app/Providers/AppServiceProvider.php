<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\ResetPassword;

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
        ResetPassword::createUrlUsing(function ($user, string $token) {

            return route('store.password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);
        });
        // if (app()->environment('local')) {
        //     \URL::forceScheme('https');
        // }
    }
}
