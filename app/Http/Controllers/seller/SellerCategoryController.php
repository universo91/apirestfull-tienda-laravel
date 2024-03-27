<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellerCategoryController extends ApiController
{

    public function index(Seller $seller)
    {
        $categories = $seller->products()
            ->with('categories:id,name,description')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();

        return $this->showAll( $categories );
    }
}
