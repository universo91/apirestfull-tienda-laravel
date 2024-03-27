<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // DESACTIVANDO LA VERIFICACION DE CLAVES FORANEAS PARA TODAS LA TABLAS. ESTO NOS FACILITARA
        // LA ELIMINACION DE LOS REGISTROS DE LAS TABLAS EN CUALQUIER ORDEN.
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Eliminando todos los registros de las tablas en la BD.
        User::truncate();
        Transaction::truncate();
        Category::truncate();
        Product::truncate();
        DB::table('category_product')->truncate();

        $cantidadUsuarios = 1000;
        $cantidadCategorias = 30;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;

        factory(User::class, $cantidadUsuarios)->create();
        factory(Category::class, $cantidadCategorias)->create();

        //Se crean 1000 instancias del modelo Producto, y por medio de la funcion each se ira recorriendo cada una de
        // esas instancias.
        factory( Product::class, $cantidadProductos)->create()->each(

            //la funcion ira recibiendo cada una de las instancias
            function( $producto ) {
                //un producto puede tener 1 o mas categorias
                $categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
                $producto->categories()->attach($categorias);
            }
        );

        factory( Transaction::class, $cantidadTransacciones)->create();
    }
}
