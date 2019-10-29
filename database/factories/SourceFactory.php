<?php

use Faker\Generator as Faker;
use App\Source;
use App\User;
use App\Preset;
use App\CurrencyRate;

$factory->define(Source::class, function (Faker $faker) {
    $user = User::first();
    if (!$user) {
        $user = factory(User::class)->create();
    }
    $preset = Preset::inRandomOrder()->first();
    if (!$preset) {
        $preset = factory(Preset::class)->create();
    }
    $currency = CurrencyRate::where('currency', 'EUR')->first();
    if (!$currency) {
        $currency = factory(CurrencyRate::class)->create();
    }
    return [
        'user_id' => $user->id,
        'currency_id' => $currency->id,
        'preset_id' => $preset->id,
        'name' => $faker->company,
        'url' => 'https://' . $faker->domainName . '/',
        'vat' => 19.0,
        'netto' => 1,
        'is_main' => 0,
    ];
});
