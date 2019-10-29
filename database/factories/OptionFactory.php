<?php

use Faker\Generator as Faker;
use App\Option;
use App\Source;
use App\User;
use App\Category;
use Carbon\Carbon;

$factory->define(Option::class, function (Faker $faker) {
    $user = User::first();
    if (!$user) {
        $user = factory(User::class)->create();
    }
    $source = Source::first();
    if (!$source) {
        $source = factory(Source::class)->create();
    }
    return [
        'source_id' => $source->id,
        'user_id' => $user->id,
        'name' => ucwords($faker->words(2, true)),
        'price' => rand(100, 5000) * 100,
        'link' => $faker->url,
        'fetched_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
