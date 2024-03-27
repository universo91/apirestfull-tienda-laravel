<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BuyerScope implements Scope {

    public function apply(Builder $builder, Model $model)
    {
        /** Solo se van a obtener las instancias que tienen transacciones */
        $builder->has('transactions');
    }
}
