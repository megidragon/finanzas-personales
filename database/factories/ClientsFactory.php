<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clients;
use App\User;
use Faker\Generator as Faker;

$factory->define(Clients::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'birth_at' => $faker->date,
        'profile_image' => null,
        'user_id' => 1,
    ];
});
