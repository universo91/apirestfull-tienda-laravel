<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductCategoryController extends ApiController
{
    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->showAll( $categories );
    }

    // Agregaremos una categoria al producto
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching( $category->id );

        return $this->showAll($product->categories);
    }

    // Eliminar una categoria de la lista de categorias de un producto
    public function delete(Product $product, Category $category)
    {
        /**
         * Antes de eliminar, es importante verificar que realmente la categoria exista asosiada a tal producto para proceder
         * con la correspondiente eliminacion de esa relacion.
         */
        if ( ! $product->categories()->find( $category->id )) {
            return $this->errorResponse('La categoria especificada no es una categoria de este producto', 404);
        }

        $product->categories()->detach( $category->id );

        return $this->showAll( $product->categories );
    }

}
