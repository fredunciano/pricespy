<?php

use Faker\Generator as Faker;
use App\ProductPriceEntry;
use App\Product;
use Carbon\Carbon;

$factory->define(ProductPriceEntry::class, function (Faker $faker) {
    $product = Product::latest()->first();
    if (!$product) {
        $product = factory(Product::class)->create();
    }
    $price = $product->price * getRandomMultiplier();
    return [
        'product_id' => $product->id,
        'price' => $price,
        'vat_price' => $price * $product->source->getVatAmplifier(),
        'fetched_at' => Carbon::now()->subDays(rand(1, 60)),
    ];
});