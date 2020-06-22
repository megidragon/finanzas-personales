<?php

namespace Tests\Feature;

use App\User;
use App\Currencies;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;


class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_logged_user_can_list()
    {
        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        $this->get('/api/currency')->assertOk();
    }

    /** @test */
    public function only_admin_can_create()
    {
        Passport::actingAs(
            factory(User::class)->create(['is_admin' => true]),
            ['create-servers']
        );
        $this->post('/api/currency', ['name' => 'Peso', 'symbol' => 'ARS'])->assertOk();
    }

    /** @test */
    public function only_admin_can_edit()
    {
        Passport::actingAs(
            factory(User::class)->create(['is_admin' => true]),
            ['create-servers']
        );
        $currency = factory(Currencies::class)->create();
        $this->put('/api/currency/'.$currency->id, ['name' => 'Peso', 'symbol' => 'ARS'])->assertOk();
    }

    /** @test */
    public function only_admin_can_delete()
    {
        Passport::actingAs(
            factory(User::class)->create(['is_admin' => true]),
            ['create-servers']
        );
        $currency = factory(Currencies::class)->create();
        $this->delete('/api/currency/'.$currency->id)->assertOk();
    }
}
