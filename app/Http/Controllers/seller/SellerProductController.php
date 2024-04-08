<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create( $data );

        return $this->showOne( $product, 201 );
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity'  => 'integer|min:1',
            'status'    => 'in:' . Product::PRODUCTO_DISPONIBLE . ',' . Product::PRODUCTO_NO_DISPONIBLE,
            'image'     => 'image'
        ];

        $this->validate($request, $rules);

        $this->verificarVendedor($seller, $product);

        $product->fill($request->intersect([
            'name',
            'description',
            'quantity'
        ]));

        /**
         * Vamos a permitir cambiar el estado si el producto ya tiene asociado al menos una categoria
         */
        if( $request->has('status'))
        {
            $product->status = $request->status;

            /**
             *  Despues de haber actualizado es estado, puede ser que el producto no este disonible,
             * por lo que se tiene que verificar. Ademas se debe verificar que la cantidad de las relaciones
             * con las categorias deben ser como minimo 1.
             * */
            if( $product->estaDisponible() && $product->categorias()->count() == 0)
            {
                return $this->errorResponse('Un producto activo debe tener al menos una categoria', 409);
            }
        }

        if($product->hasFile('image')) {
            Storage::delete( $product->image );
            $product->image = $request->image->store('');
        }

        /**
         * Se verifica si se ha modificado sobre esta instancia
         */
        if($product->isClean())
        {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para acutualizar', 422);
        }

        $product->save();

        return $this->showOne( $$product );
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->verificarVendedor($seller, $product);

        Storage::delete($product->image);

        $product->delete();

        return $this->showOne( $product );
    }

    protected function verificarVendedor(Seller $seller, Product $product)
    {
        if( $seller->id != $product->seller_id )
        {
            throw new HttpException(422, 'El vendedor especificado no es el vendedor real del producto');
        }
    }
}
