<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    public function index(Buyer $buyer) {
        //Obtenemos los vendedores  de los compradores
        $sellers = $buyer->transactions()->with('product.seller')
                    ->get()
                    ->pluck('product.seller')
                    ->unique()
                    ->values();

        return $this->showAll( $sellers );
    }
}
