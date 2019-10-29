<?php

use Faker\Generator as Faker;
use App\CurrencyRate;

$factory->define(CurrencyRate::class, function (Faker $faker) {
    return [
        'currency' => strtoupper(str_random(3)),
        'rate' => $faker->randomFloat(3, 0, 2)
    ];
});
