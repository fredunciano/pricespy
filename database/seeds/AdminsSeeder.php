<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@pricefeed.de',
            'password' => bcrypt('adminP123'),

        ]);
    }
}
