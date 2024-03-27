<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductController extends ApiController
{

    public function index()
    {
        $products = Product::all();
        return $products;
        return $this->showAll($products);
    }

    public function show(Product $product)
    {
        //INternamente existe un Product::findOrFail(idProduct)
        return $this->showOne($product);
    }
}
