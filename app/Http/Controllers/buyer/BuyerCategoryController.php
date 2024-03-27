<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{
    //Obtener todas las categorias en las cuales un comprador a realizado compras.
    public function index(Buyer $buyer) {
        $categories = $buyer->transactions()->with('product.categories')
            ->get()
            ->pluck('product.categories') // retorna varios conjuntos de colecciones, como elementos de otra coleccion
            ->collapse() // para agrupar en una sola coleccion, usamos collapse
            ->unique('id')
            ->values();

        return $this->showAll($categories);
    }
}
