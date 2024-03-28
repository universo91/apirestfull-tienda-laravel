<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{

    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll( $products );
    }

    /**
     * Metodo para almacenar productos.
     * Cabe la posiblidad de que un usuario cualquiera, que aun no es vendedor quiera publicar un producto
     * por primera vez. Qeuiere decir que en ese punto para el sistema aun no es un vendedor, es un usuario
     * comun. Asi que en realidad no debemos pasar como parametro instancias de vendedores(Seller), sino
     * de un usuario como tal, para que de esa manera facilitemos a que un usuario nuevo que nunca
     * ah vendido algo, pueda publicar un producto por primera vez.
     */
    public function store(Request $request, User $seller)
    {
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
            'quantity'      => 'required|integer|min:1',
            'image'         => 'required|image'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;

        $product = Product::create( $data );

        return $this->showOne( $product, 201 );
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
