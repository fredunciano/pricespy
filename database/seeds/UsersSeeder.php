<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Verpackungen',
                'company' => 'verpackungen',
                'email' => 'admin@verpackungen.com',
                'password' => bcrypt('admin123'),
                'email_verified_at' => \Carbon\Carbon::now()
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
