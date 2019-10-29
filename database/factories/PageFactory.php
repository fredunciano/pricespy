<?php

use Faker\Generator as Faker;
use App\Page;
use App\Source;
use App\Category;
use App\User;

$factory->define(Page::class, function (Faker $faker) {
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
    return [
        'user_id' => $user->id,
        'source_id' => $source->id,
        'url' => $source->url . 'listing/' . $category . 's',
        'type' => 'listing',
        'category_id' => $category->id,
    ];
});
