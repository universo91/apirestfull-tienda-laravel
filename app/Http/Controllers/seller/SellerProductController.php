<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{

    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll( $products );
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Seller $seller)
    {
        //
    }

    public function destroy(Seller $seller)
    {
        //
    }
}
