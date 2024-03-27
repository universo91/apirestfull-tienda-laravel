<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{

    public function index()
    {
        $compradores = Buyer::has('transactions')->get();

        return $this->showAll($compradores);
    }

    /* public function show($id)
    {
        $comprador = Buyer::has('transactions')->findOrFail($id);
        return $this->showOne($comprador);
    } */

    /**
     * Gracias al uso del global scope, ahora is es posible usar la instancia implicita pra Buyer.
     */
    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }




}
