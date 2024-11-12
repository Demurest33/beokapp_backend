<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\myUser;
use Illuminate\Support\Facades\Hash;

class MyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        myUser::create([
            'name' => 'Admin',
            'lastname' => 'User',
            'role' => myUser::ROLE_ADMIN,
            'phone' => '2294121325',
            'password' => 'adminpassword',
            'verified_at' => now(),
        ]);

        myUser::create([
            'name' => 'John',
            'lastname' => 'Doe',
            'role' => myUser::ROLE_CLIENTE,
            'phone' => '0987654321',
            'password' => 'clientpassword',
            'verified_at' => null,
        ]);
    }
}
