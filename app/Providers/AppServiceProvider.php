<?php

namespace App\Providers;

use App\Mail\UserCreated;
use Illuminate\Support\ServiceProvider;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created( function($user) {
            Mail::to($user->email)->send(new UserCreated($user));
        });

         //El parametro $product del closure, viene a ser la instancia que se está actualizando
         Product::updated( function($product) {
            if( $product->quantity == 0 && $product->estaDisponible() ) {
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;

                $product->save();
            }
        });
    }
}
