<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EmirateSeeder::class,
            MarketSeeder::class,
            DistrictSeeder::class,
            NeighbourSeeder::class,
            BranchSeeder::class,
            PagesSeeder::class,
            OfferCategorySeeder::class,
            SettingsTableSeeder::class,
            OfferSeeder::class,
            PostSeeder::class,
            CouponSeeder::class,
        ]);
    }
}
