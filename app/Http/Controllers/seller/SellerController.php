<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellerController extends ApiController
{

    public function index()
    {
        $vendedores = Seller::has('products')->get();

        return $this->showAll( $vendedores );
    }

    /* public function show($id)
    {
        $vendedor = Seller::has('products')->findOrFail($id);

        return $this->showOne($vendedor);
    } */

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }
}
