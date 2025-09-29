<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Admin GRTech',
                'email' => 'admin@grtech.com',
                'password' => bcrypt('password'),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'User GRTech',
                'email' => 'user@grtech.com',
                'password' => bcrypt('password'),
            ],
        ]);
    }
}
