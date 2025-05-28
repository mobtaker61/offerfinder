<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\Market;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $categories = OfferCategory::all();
        $markets = Market::whereHas('branches')->get();

        if ($markets->isEmpty()) {
            $this->command->info('No markets with branches found. Skipping offer seeding.');
            return;
        }

        // Active offers (15)
        for ($i = 0; $i < 15; $i++) {
            $market = $markets->random();
            $marketBranches = Branch::where('market_id', $market->id)->get();
            
            $startDate = $now->copy()->subDays(rand(1, 30));
            $endDate = $now->copy()->addDays(rand(1, 30));

            Offer::create([
                'title' => "Active Offer " . ($i + 1),
                'description' => "This is an active offer with great discounts!",
                'start_date' => $startDate,
                'end_date' => $endDate,
                'category_id' => $categories->random()->id,
                'market_id' => $market->id,
                'vip' => rand(0, 1),
            ])->branches()->attach($marketBranches->random(rand(1, min(3, $marketBranches->count())))->pluck('id'));
        }

        // Upcoming offers (10)
        for ($i = 0; $i < 10; $i++) {
            $market = $markets->random();
            $marketBranches = Branch::where('market_id', $market->id)->get();
            
            $startDate = $now->copy()->addDays(rand(1, 30));
            $endDate = $startDate->copy()->addDays(rand(7, 30));

            Offer::create([
                'title' => "Upcoming Offer " . ($i + 1),
                'description' => "Get ready for this amazing upcoming offer!",
                'start_date' => $startDate,
                'end_date' => $endDate,
                'category_id' => $categories->random()->id,
                'market_id' => $market->id,
                'vip' => rand(0, 1),
            ])->branches()->attach($marketBranches->random(rand(1, min(3, $marketBranches->count())))->pluck('id'));
        }

        // Expired offers (5)
        for ($i = 0; $i < 5; $i++) {
            $market = $markets->random();
            $marketBranches = Branch::where('market_id', $market->id)->get();
            
            $endDate = $now->copy()->subDays(rand(1, 30));
            $startDate = $endDate->copy()->subDays(rand(7, 30));

            Offer::create([
                'title' => "Expired Offer " . ($i + 1),
                'description' => "This offer has ended. Stay tuned for more!",
                'start_date' => $startDate,
                'end_date' => $endDate,
                'category_id' => $categories->random()->id,
                'market_id' => $market->id,
                'vip' => rand(0, 1),
            ])->branches()->attach($marketBranches->random(rand(1, min(3, $marketBranches->count())))->pluck('id'));
        }
    }
} 