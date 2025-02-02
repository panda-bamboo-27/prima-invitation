<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $password = "123456";
        $admin = [
            'name' => "John Doe",
            'email' => "johndoe@test.com",
            'email_verified_at' => now(),
            'role'  => 'admin',
            'password' => Hash::make('password'),
        ];

        $guest = [
            'name' => "Jane Doe",
            'email' => "janedoe@test.com",
            'email_verified_at' => now(),
            'role'  => 'guest',
            'password' => Hash::make('password'),
        ];
        // User::factory()->create($admin);
        User::factory()->create($guest);
    }
}
