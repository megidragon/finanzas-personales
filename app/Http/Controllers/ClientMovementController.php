<?php

namespace App\Http\Controllers;

use App\Helpers\Responses;
use App\Http\Repositories\MovementRepository;
use App\Http\Requests\MovementCreateRequest;
use Illuminate\Http\Request;

class ClientMovementController extends Controller
{
    use Responses;
    /**
     * Obtiene balance del cliente
     */
    public function getBalance()
    {
        $balance = MovementRepository::getBalance();
        return $this->listResponse(['balance' => $balance]);
    }

    /**
     * Crea nuevo deposito
     */
    public function newDeposit(MovementCreateRequest $request)
    {
        MovementRepository::newMovement(
            $request->title,
            $request->description,
            $request->amount,
            $request->category_id,
            $request->currency_id,
            'deposit'
        );

        return $this->storeSuccess();
    }

    /**
     * Crea nuevo gasto
     */
    public function newSpending(MovementCreateRequest $request)
    {
        MovementRepository::newMovement(
            $request->title,
            $request->description,
            $request->amount,
            $request->category_id,
            $request->currency_id,
            'spending'
        );

        return $this->storeSuccess();
    }
}
