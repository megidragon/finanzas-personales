<?php

namespace App\Http\Repositories;

use App\Movements;
use App\User;

class MovementRepository
{
    public static function getBalance() : float
    {
        $client_id = User::clientId(auth()->id());
        return Movements::where('client_id', $client_id)->sum('amount');
    }

    public static function newMovement(string $title, string $description, float $amount, int $category_id, int $currency_id, string $type) : void
    {
        $client_id = User::clientId(auth()->id());
        Movements::create([
          'title' => $title,
          'description' => $description,
          'amount' => $amount,
          'type' => $type,
          'category_id' => $category_id,
          'currency_id' => $currency_id,
          'client_id' => $client_id
        ]);
    }
}
