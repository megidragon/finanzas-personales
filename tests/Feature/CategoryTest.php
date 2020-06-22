<?php

namespace Tests\Feature;

use App\Categories;
use App\User;
use App\Currencies;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;


class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_logged_user_can_list()
    {
        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        factory(Categories::class)->create();
        $this->get('/api/category')->assertOk();
    }

    /** @test */
    /*public function only_admin_can_create()
    {
        Passport::actingAs(
            factory(User::class)->create(['is_admin' => true]),
            ['create-servers']
        );
        $this->post('/api/category', ['name' => 'Test'])->assertOk();
    }*/

    /** @test */
    /*public function only_admin_can_edit()
    {
        Passport::actingAs(
            factory(User::class)->create(['is_admin' => true]),
            ['create-servers']
        );
        $category = factory(Categories::class)->create();
        $this->put('/api/category/'.$category->id, ['name' => 'Test'])->assertOk();
    }*/

    /** @test */
    /*public function only_admin_can_delete()
    {
        Passport::actingAs(
            factory(User::class)->create(['is_admin' => true]),
            ['create-servers']
        );
        $category = factory(Categories::class)->create();
        $this->delete('/api/category/'.$category->id)->assertOk();
    }*/
}
