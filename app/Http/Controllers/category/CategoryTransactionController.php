<?php

namespace App\Http\Controllers\category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Transaction;

class CategoryTransactionController extends ApiController
{

    public function index(Category $category)
    {
        /**
         * Los productos tienen o estan dentro de las transacciones, pero es posible que muchos de los productos de algunas
         * categorias aun no tengan transacciones. Esto quiere decir que la realizar una consulta de las transacciones, muchas
         * de estas seran vacias.
         * Para solucionar este problema, usamos el metodo whereHas
         */
         $transactions = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll( $transactions );
    }
}
