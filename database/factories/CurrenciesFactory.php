<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Currencies;
use Faker\Generator as Faker;

$factory->define(Currencies::class, function (Faker $faker) {
    return [
        'name' => $faker->currencyCode,
        'symbol' => $faker->currencyCode
    ];
});
