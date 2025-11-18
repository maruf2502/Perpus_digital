<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@site.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Pustakawan
        User::create([
            'name' => 'Pustakawan User',
            'email' => 'pustakawan@site.com',
            'password' => Hash::make('password'),
            'role' => 'pustakawan'
        ]);

        // Member
        User::create([
            'name' => 'Member User',
            'email' => 'member@site.com',
            'password' => Hash::make('password'),
            'role' => 'member'
        ]);
    }
}
