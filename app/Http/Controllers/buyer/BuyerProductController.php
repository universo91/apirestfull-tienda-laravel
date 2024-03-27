<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{

    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()
            ->with('product:id,name,description')
            ->get()
            ->pluck('product');

        return $this->showAll( $products );
    }

}
