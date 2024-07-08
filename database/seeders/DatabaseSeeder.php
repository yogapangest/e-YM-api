<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'alamat' => 'yatimmandiri',
            'telephone' => '0812768915',
            'password' => '12345678',
            'role' => 'Admin',
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'User@gmail.com',
            'username' => 'user',
            'alamat' => 'yatimmandiri',
            'telephone' => '0812768915',
            'password' => '12345678',
            'role' => 'User'
        ]);
    }
}