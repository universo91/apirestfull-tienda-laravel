<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
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
            retry( 4, function() use ($user) {
                Mail::to($user->email)->send(new UserCreated($user));
            },100 );
        });

        /*  User::updated( function($user) { //PRIMERA IMPLEMENTACION

             if( $user->isDirty('email') ) {
                 Mail::to($user->email)->send( new UserMailChanged($user) );
             }
         }); */

         User::updated( function($user) { // SEGUNDA IMPLEMENTACION

            retry(5, function() use ($user) {
                if( $user->isDirty('email') ) {
                    Mail::to($user->email)->send( new UserMailChanged($user) );
                }
            }, 100);

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
