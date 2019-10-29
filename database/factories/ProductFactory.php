<?php

use Faker\Generator as Faker;
use App\Product;
use App\Source;
use App\User;
use App\Category;
use Carbon\Carbon;

$factory->define(Product::class, function (Faker $faker) {
    $user = User::first();
    if (!$user) {
        $user = factory(User::class)->create();
    }
    $source = Source::first();
    if (!$source) {
        $source = factory(Source::class)->create();
    }
    $category = Category::first();
    if (!$category) {
        $category = factory(Category::class)->create();
    }
    $price = rand(100, 5000);
    return [
        'source_id' => $source->id,
        'user_id' => $user->id,
        'origin' => 'seed',
        'name' => ucwords($faker->words(2, true)),
        'category_id' => $category->id,
        'price' => $price,
        'vat_price' => (int) $price * $source->getVatAmplifier(),
        'link' => $faker->url,
        'is_watched' => rand(0, 1),
        'fetched_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
