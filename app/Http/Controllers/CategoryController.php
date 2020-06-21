<?php

namespace App\Http\Controllers;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;

use Illuminate\Http\Request;
use App\Helpers\Responses;
use App\Categories;

class CategoryController extends Controller
{
    use Responses;

    /**
     * Listado de categorias
     */
    protected function list() 
    {
        $rows = Categories::all();
        
        return $this->listResponse($rows);
    }

    /**
     * Creacion de categoria
     */
    protected function store(CategoryCreateRequest $request) 
    {
        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        }

        // Alta de categoria
        $row = Categories::create([
            'name' => $request->name,
            'type' => $request->type,
            'client_id' => $request->client_id
        ])->fresh();
        
        return $this->storeSuccess($row);
    }

    /**
     * Actualizacion de categoria
     */
    protected function update(CategoryUpdateRequest $request, $id) 
    {
        $category = Categories::find($id);

        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        } 
        elseif (!$category || $category->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $input = $request->only(['name', 'type']);

        $category->fill($input)->save();

        return $this->updateSuccess($category->fresh());
    }

    /**
     * Borrado de categoria
     */
    protected function delete($id) 
    {
        $category = Categories::find($id);
        if (!$category || $category->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $category->delete();

        return $this->deleteSuccess();
    }
}
