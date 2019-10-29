<?php

use Illuminate\Database\Seeder;
use App\Source;
use App\Page;
use App\Category;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Source::all()->each(function($source) {
            $categories = Category::all();
            $categoryIds = $categories->pluck('id')->toArray();
            foreach ($categories as $category) {
                factory(Page::class)->create([
                    'user_id' => $source->user_id,
                    'source_id' => $source->id,
                    'url' => $source->url . 'listing/' . $category->display_name . 's',
                    'category_id' => array_random($categoryIds),
                ]);
            }
        });
    }
}
