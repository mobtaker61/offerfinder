<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emirate;
use Carbon\Carbon;

class EmirateSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $emirates = [
            [
                'id' => 1,
                'name' => 'Abu Dhabi',
                'local_name' => 'أبوظبي',
                'latitude' => 24.4539,
                'longitude' => 54.3773,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'Ajman',
                'local_name' => 'عجمان',
                'latitude' => 25.4052,
                'longitude' => 55.5136,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'name' => 'Dubai',
                'local_name' => 'دبي',
                'latitude' => 25.2048,
                'longitude' => 55.2708,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'name' => 'Fujairah',
                'local_name' => 'الفجيرة',
                'latitude' => 25.4111,
                'longitude' => 56.2482,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'name' => 'Ras Al Khaimah',
                'local_name' => 'رأس الخيمة',
                'latitude' => 25.7877,
                'longitude' => 55.9432,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 6,
                'name' => 'Sharjah',
                'local_name' => 'الشارقة',
                'latitude' => 25.3463,
                'longitude' => 55.4209,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 7,
                'name' => 'Umm Al Quwain',
                'local_name' => 'أم القيوين',
                'latitude' => 25.5647,
                'longitude' => 55.5532,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        foreach ($emirates as $emirate) {
            Emirate::updateOrCreate(
                [
                    'id' => $emirate['id']
                ],
                $emirate
            );
        }
    }
} 