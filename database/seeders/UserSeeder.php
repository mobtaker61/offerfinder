<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Manoochehr Totonchi',
            'email' => 'offer@roniplus.ae',
            'password' => Hash::make('Demo1234'),
            'is_active' => true,
            'user_type' => User::TYPE_WEBMASTER,
            'created_at' => '2025-03-10 01:39:40',
            'updated_at' => '2025-03-10 01:39:40',
        ]);
    }
} 