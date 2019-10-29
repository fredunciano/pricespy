<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\User;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function($user) {
            $categories = collect([
                [
                    'name' => 'Phone',
                    'slug' => 'phone',
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'Laptop',
                    'slug' => 'laptop',
                    'user_id' => $user->id,
                ],
            ]);

            $categories->each(function($category) {
                factory(Category::class)->create($category);
            });
        });

    }
}
