<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use App\Clients;
use Faker\Generator as Faker;

$factory->define(Categories::class, function (Faker $faker) {
    $use_client = $faker->randomElement([true, false]);
    return [
        'name' => $faker->colorName,
        'client_id' => $use_client ? (Clients::inRandomOrder()->value('id') ?: factory(Clients::class)) : null
    ];
});
