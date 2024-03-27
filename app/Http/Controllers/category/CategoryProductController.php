<?php

namespace App\Http\Controllers\category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryProductController extends ApiController
{
    public function index(Category $category)
    {
        $products = $category->products;

        return $this->showAll( $products );
    }
}
