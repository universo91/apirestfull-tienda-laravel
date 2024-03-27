<?php

namespace App\Http\Controllers\category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategorySellerController extends ApiController
{

    public function index(Category $category)
    {
        $sellers = $category->products()->with('seller:id,name,email')
                    ->get()
                    ->pluck('seller')
                    ->unique('id')
                    ->values();

        return $this->showAll( $sellers );
    }

}
