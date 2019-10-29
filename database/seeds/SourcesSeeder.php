<?php

use Illuminate\Database\Seeder;
use App\Source;
use App\User;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function($user) {
            factory(Source::class)->create([
                'name' => 'Dein Laden',
                'is_main' => 1,
                'user_id' => $user->id,
            ]);

            factory(Source::class, 5)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
