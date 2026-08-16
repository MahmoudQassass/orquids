<?php

namespace App\Providers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            $cartCount = 0;

            if (Auth::check()) {

                $cartCount = Auth::user()
                    ->cartItems()
                    ->sum('quantity');

            } else {

                $cart = session()->get('cart', []);

                $cartCount = array_sum($cart);
            }

            $view->with(
                'cartCount',
                (int) $cartCount
            );
        });
    }
}
