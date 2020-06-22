<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clients;
use App\Categories;
use App\Currencies;
use Faker\Generator as Faker;

$factory->define(\App\Movements::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-2 years');
    $type = $faker->randomElement([\Config::get('constants.SPENDING_KEY'), \Config::get('constants.DEPOSIT_KEY')]);
    $max = $type == \Config::get('constants.SPENDING_KEY') ? 6000 : 9999.99;
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->optional()->text,
        'amount' => $faker->randomFloat(4, 0, $max),
        'type' => $type,
        'category_id' => Categories::inRandomOrder()->value('id') ?: factory(Categories::class),
        'client_id' => Clients::inRandomOrder()->value('id') ?: factory(Clients::class),
        'currency_id' => Currencies::inRandomOrder()->value('id') ?: factory(Currencies::class),
        'created_at' => $date,
        'updated_at' => $date
    ];
});
