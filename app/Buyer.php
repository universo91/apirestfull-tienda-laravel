<?php

namespace App;

use App\Scopes\BuyerScope;
use App\Transaction;
use App\Product;


class Buyer extends User
{
    public function transactions() {
        return $this->hasMany( Transaction::class );
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope( new BuyerScope );
    }
}
