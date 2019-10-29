<?php

use Faker\Generator as Faker;
use App\Preset;

$factory->define(Preset::class, function (Faker $faker) {
    return [
        'title' => '.' . $faker->word,
        'element' => '.' . $faker->word,
        'name' => '.' . $faker->word,
        'description' => '.' . $faker->word,
        'link' => '.' . $faker->word,
        'price' => '.' . $faker->word,
    ];
});
