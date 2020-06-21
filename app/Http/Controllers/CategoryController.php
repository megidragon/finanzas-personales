<?php

namespace App\Http\Controllers;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;

use Illuminate\Http\Request;
use App\Helpers\Responses;
use App\Categories;
use App\User;

class CategoryController extends Controller
{
    use Responses;

    /**
     * Listado de categorias
     * Acepta parametro show_all (boolean) para traer todos los registros.
     */
    protected function list(Request $request) 
    {
        $rows = new Categories;
        if (!auth()->user()->is_admin) 
        {
            $client_id = User::clientId(auth()->id());
            $rows = $rows->where('client_id', $client_id);
        }
        elseif (empty($request->show_all))
        {
            $rows = $rows->where('client_id', null);
        }
        
        return $this->listResponse($rows->get());
    }

    /**
     * Creacion de categoria global
     */
    protected function storeCategory(CategoryCreateRequest $request) 
    {
        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        }

        // Alta de categoria global
        $row = Categories::create([
            'name' => $request->name
        ])->fresh();
        
        return $this->storeSuccess($row);
    }

    /**
     * Creacion de categoria personal
     */
    protected function storeClientCategory(CategoryCreateRequest $request) 
    {
        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        }

        $client_id = User::clientId(auth()->id());

        // Alta de categoria global
        $row = Categories::create([
            'name' => $request->name,
            'client_id' => $client_id
        ])->fresh();
        
        return $this->storeSuccess($row);
    }

    /**
     * Actualizacion de categoria
     */
    protected function update(CategoryUpdateRequest $request, $id) 
    {
        $client_id = auth()->user()->is_admin ? null : User::clientId(auth()->id());
        $category = Categories::where('client_id', $client_id)->find($id);

        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        } 
        elseif (!$category || $category->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $input = $request->only(['name']);

        $category->fill($input)->save();

        return $this->updateSuccess($category->fresh());
    }

    /**
     * Borrado de categoria
     */
    protected function delete($id) 
    {
        $client_id = auth()->user()->is_admin ? null : User::clientId(auth()->id());
        $category = Categories::where('client_id', $client_id)->find($id);

        if (!$category || $category->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $category->delete();

        return $this->deleteSuccess();
    }
}
