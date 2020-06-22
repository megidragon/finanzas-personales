<?php

namespace Tests\Feature;

use App\Categories;
use App\Clients;
use App\User;
use App\Currencies;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;


class MovementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /*public function only_client_can_list()
    {
        $user = factory(User::class)->create(['is_admin' => false]);
        Passport::actingAs($user, ['create-servers']);
        $client = factory(Clients::class)->create(['user_id' => $user->id]);

        $this->get('/api/movement?year=2020&month=5')->assertOk();
    }*/

    /** @test */
    /*public function only_admin_can_create()
    {
        $user = factory(User::class)->create(['is_admin' => false]);
        Passport::actingAs($user, ['create-servers']);
        $client = factory(Clients::class)->create(['user_id' => $user->id]);
        
        $category = factory(Categories::class)->create();
        $currency = factory(Currencies::class)->create();

        dd($this->post('/api/movement', [
            "title" => "Deposito sueldo",
            "description" => "C/30 Dias",
            "amount" => 100.9,
            "category_id" => $category->id,
            "currency_id" => $currency->id,
            "type" => "deposit",
            "date_at" => "2020-06-21"
        ])->decodeResponseJson());
        
        $this->post('/api/movement', [
            "title" => "Deposito sueldo",
            "description" => "C/30 Dias",
            "amount" => 100.9,
            "category_id" => $category->id,
            "currency_id" => $currency->id,
            "type" => "deposit",
            "date_at" => "2020-06-21"
        ])->assertOk();
    }*/
}
