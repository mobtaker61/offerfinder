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
            'id' => 1,
            'name' => 'Manoochehr Totonchi',
            'email' => 'offer@roniplus.ae',
            'password' => Hash::make('Demo1234'),
            'phone' => '+971562858133',
            'avatar' => 'https://via.placeholder.com/150',
            'bio' => 'I am Manoochehr',
            'location' => 'Dubai, UAE',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'facebook_url' => 'https://www.facebook.com/manoochehr.totonchi',
            'twitter_url' => 'https://www.twitter.com/manoochehr.totonchi',
            'instagram_url' => 'https://www.instagram.com/manoochehr.totonchi',
            'linkedin_url' => 'https://www.linkedin.com/in/manoochehr.totonchi',
            'newsletter' => true,
            'is_active' => true,
            'user_type' => User::TYPE_WEBMASTER,
            'created_at' => '2025-03-10 01:39:40',
            'updated_at' => '2025-03-10 01:39:40',
            'email_verified_at' => '2025-03-10 01:39:40'            
        ],
        [
            'id' => 2,
            'name' => 'Arsham Hasani',
            'email' => 'arsham.hasani@gmail.com',
            'password' => Hash::make('Demo1234'),
            'phone' => '+989123456789',
            'avatar' => 'https://via.placeholder.com/150',
            'bio' => 'I am Arsham',
            'location' => 'Tehran, Iran',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'facebook_url' => 'https://www.facebook.com/arsham.hasani',
            'twitter_url' => 'https://www.twitter.com/arsham.hasani',
            'instagram_url' => 'https://www.instagram.com/arsham.hasani',
            'linkedin_url' => 'https://www.linkedin.com/in/arsham.hasani',
            'newsletter' => true,
            'is_active' => true,
            'user_type' => User::TYPE_WEBMASTER,
            'created_at' => '2025-03-10 01:39:40',
            'updated_at' => '2025-03-10 01:39:40',
            'email_verified_at' => '2025-03-10 01:39:40'            
        ]);
    }
} 