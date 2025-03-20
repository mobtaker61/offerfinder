<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        $districts = [
            [
                'id' => 1,
                'name' => 'Deira',
                'local_name' => 'دیره',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Mushrif',
                'local_name' => 'مشرف',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Bur Dubai',
                'local_name' => 'بر دوبی',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Ras Al Khor',
                'local_name' => 'راس الخور',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Jabal Ali',
                'local_name' => 'جبل علی',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Hadaeq Sheikh Mohammed Bin Rashid',
                'local_name' => 'حدایق شیخ محمد بن راشید',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Al Awir',
                'local_name' => 'العویر',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Hatta',
                'local_name' => 'حتا',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Al Marmoom',
                'local_name' => 'المارون',
                'emirate_id' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($districts as $district) {
            District::create($district);
        }
    }
} 