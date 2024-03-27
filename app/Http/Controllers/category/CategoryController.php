<?php

namespace App\Http\Controllers\category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

    public function index()
    {
        $categorias = Category::all();
        return $this->showAll($categorias);
    }

    public function store(Request $request)
    {
        $rule = [
            "name" => 'required|unique:Category',
            "description" => 'required'
        ];

        $this->validate($request, $rule);

        $category = Category::create($request->all());

        return $this->showOne($category, 201);
    }

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->intersect(['name', 'description']));

        //Si la instancia no ah cambiado vamos a retornar un error
        if( $category->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        //En caso de que la categoria se haya cambiado, es decir el nombre, la descripcion o ambos han sido modificados
        // a partir de la peticion, entonces vamos a guardar los cambios utilizando el metodo save.
        $category->save();

        return $this->showOne($category);


    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category);
    }

}
