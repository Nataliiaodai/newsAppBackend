<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'testUser@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('testPassword'),
            'remember_token' => null,
        ]);
    }
}
