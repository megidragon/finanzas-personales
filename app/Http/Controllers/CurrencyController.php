<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyCreateRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use App\Helpers\Responses;
use App\Currencies;

class CurrencyController extends Controller
{
    use Responses;

    /**
     * Listado de monedas
     */
    protected function list() 
    {
        $rows = Currencies::all();
        
        return $this->listResponse($rows);
    }

    /**
     * Creacion de nueva moneda
     */
    protected function store(CurrencyCreateRequest $request) 
    {
        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        }

        $row = Currencies::create([
            'name' => $request->name,
            'symbol' => $request->symbol
        ])->fresh();
        
        return $this->storeSuccess($row);
    }

    /**
     * Actualizacion de moneda
     */
    protected function update(CurrencyUpdateRequest $request, $id) 
    {
        $currency = Currencies::find($id);

        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request->validator->errors());
        } 
        elseif (!$currency || $currency->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $input = $request->only(['name', 'symbol']);

        $currency->fill($input)->save();

        return $this->updateSuccess($currency->fresh());
    }

    /**
     * Borrado de moneda
     */
    protected function delete($id) 
    {
        $currency = Currencies::find($id);
        if (!$currency || $currency->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $currency->delete();

        return $this->deleteSuccess();
    }
}
