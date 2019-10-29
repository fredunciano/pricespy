<?php

use Faker\Generator as Faker;
use App\Category;
use App\User;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->words(2, true);
    $user = User::first();
    if (!$user) {
        $user = factory(User::class)->create();
    }
    return [
        'user_id' => $user->id,
        'name' => ucwords($name),
        'slug' => str_replace('_', '-', snake_case($name)),
        'description' => $faker->text(100),
    ];
});
