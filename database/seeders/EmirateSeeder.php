<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emirate;
use Illuminate\Support\Facades\DB;

class EmirateSeeder extends Seeder
{
    public function run(): void
    {
        $emirates = [
            ['id' => 1, 'name' => 'Abu Dhabi'],
            ['id' => 2, 'name' => 'Ajman'],
            ['id' => 3, 'name' => 'Dubai'],
            ['id' => 4, 'name' => 'Fujairah'],
            ['id' => 5, 'name' => 'Ras Al Khaimah'],
            ['id' => 6, 'name' => 'Sharjah'],
            ['id' => 7, 'name' => 'Umm Al Quwain'],
        ];

        foreach ($emirates as $emirate) {
            Emirate::create($emirate);
        }
    }
} 