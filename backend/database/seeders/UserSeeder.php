<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'name',
                'email' => 'mantis@test.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]
        ]);
    }
}
