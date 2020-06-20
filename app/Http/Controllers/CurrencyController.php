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
        
        return self::listResponse($rows);
    }

    /**
     * Creacion de nueva moneda
     */
    protected function store(CurrencyCreateRequest $request) 
    {
        // Validaciones correspondientes
        if (isset($request->validator) && $request->validator->fails())
        {
            return $this->validateFailed($request);
        }

        $row = Currencies::create([
            'name' => $request->name,
            'symbol' => $request->symbol
        ])->fresh();
        
        return self::storeSuccess($row);
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
            return $this->validateFailed($request->validator->messages());
        } 
        elseif (!$currency || $currency->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->save();

        return self::updateSuccess();
    }

    /**
     * Borrado de moneda
     */
    protected function delete(Request $request, $id) 
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
