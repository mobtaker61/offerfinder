<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Market;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $markets = Market::all();
        $branches = Branch::all();

        $coupons = [
            [
                'title' => 'Summer Sale 2024',
                'description' => 'Get amazing discounts on summer items',
                'image' => 'coupons/summer-sale.jpg',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(30),
                'is_unlimited' => true,
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Market::class,
                'couponable_id' => $markets->random()->id,
            ],
            [
                'title' => 'Weekend Special',
                'description' => 'Special weekend discounts',
                'image' => 'coupons/weekend-special.jpg',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(5),
                'is_unlimited' => false,
                'usage_limit' => 100,
                'used_count' => 45,
                'is_active' => true,
                'couponable_type' => Branch::class,
                'couponable_id' => $branches->random()->id,
            ],
            [
                'title' => 'Early Bird Offer',
                'description' => 'Get early morning discounts',
                'image' => 'coupons/early-bird.jpg',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(40),
                'is_unlimited' => false,
                'usage_limit' => 50,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Market::class,
                'couponable_id' => $markets->random()->id,
            ],
            [
                'title' => 'Flash Sale',
                'description' => 'Limited time flash sale',
                'image' => 'coupons/flash-sale.jpg',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(2),
                'is_unlimited' => true,
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Branch::class,
                'couponable_id' => $branches->random()->id,
            ],
            [
                'title' => 'Holiday Special',
                'description' => 'Special holiday discounts',
                'image' => 'coupons/holiday-special.jpg',
                'start_date' => now()->addDays(15),
                'end_date' => now()->addDays(45),
                'is_unlimited' => false,
                'usage_limit' => 200,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Market::class,
                'couponable_id' => $markets->random()->id,
            ],
            [
                'title' => 'Member Exclusive',
                'description' => 'Exclusive deals for members',
                'image' => 'coupons/member-exclusive.jpg',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'is_unlimited' => false,
                'usage_limit' => 75,
                'used_count' => 30,
                'is_active' => true,
                'couponable_type' => Branch::class,
                'couponable_id' => $branches->random()->id,
            ],
            [
                'title' => 'Clearance Sale',
                'description' => 'Clearance items at great prices',
                'image' => 'coupons/clearance.jpg',
                'start_date' => now()->addDays(3),
                'end_date' => now()->addDays(20),
                'is_unlimited' => true,
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Market::class,
                'couponable_id' => $markets->random()->id,
            ],
            [
                'title' => 'New Year Special',
                'description' => 'Start the new year with great deals',
                'image' => 'coupons/new-year.jpg',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(50),
                'is_unlimited' => false,
                'usage_limit' => 150,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Branch::class,
                'couponable_id' => $branches->random()->id,
            ],
            [
                'title' => 'Seasonal Sale',
                'description' => 'Seasonal items at discounted prices',
                'image' => 'coupons/seasonal.jpg',
                'start_date' => now()->subDays(3),
                'end_date' => now()->addDays(15),
                'is_unlimited' => false,
                'usage_limit' => 80,
                'used_count' => 25,
                'is_active' => true,
                'couponable_type' => Market::class,
                'couponable_id' => $markets->random()->id,
            ],
            [
                'title' => 'Limited Time Offer',
                'description' => 'Limited time special discounts',
                'image' => 'coupons/limited-time.jpg',
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(35),
                'is_unlimited' => true,
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'couponable_type' => Branch::class,
                'couponable_id' => $branches->random()->id,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
} 