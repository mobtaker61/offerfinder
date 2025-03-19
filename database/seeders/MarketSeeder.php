<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Market;
use Illuminate\Support\Facades\DB;

class MarketSeeder extends Seeder
{
    public function run(): void
    {
        $markets = [
            [
                'id' => 1,
                'name' => 'Nesto',
                'logo' => 'market/CE8HGtLP84hRwq35L9rk4NN2GiQN8z3NrDg8NvF3.png',
                'website' => 'https://nestomakrket.com',
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => null,
                'created_at' => '2025-03-12 22:44:56',
                'updated_at' => '2025-03-15 06:16:54'
            ],
            [
                'id' => 2,
                'name' => 'Lu Lu Hypermarket',
                'logo' => 'market/nEuCfTYR4QOyXFKB5ErwbE0xzfM5vHNgWObPjAQR.png',
                'website' => 'https://luluhypermarket.com',
                'android_app_link' => 'https://play.google.com/store/apps/details?id=com.akinon.lulushopping&pli=1',
                'ios_app_link' => 'https://apps.apple.com/ae/app/lulu-hypermarket/id123456789',
                'whatsapp' => 'https://wa.me/9718005858',
                'created_at' => '2025-03-12 22:49:12',
                'updated_at' => '2025-03-15 06:17:04'
            ],
            [
                'id' => 3,
                'name' => 'Gift Villages',
                'logo' => 'market/wGlPbJYIogcLQfXLhoriCKk6zGcV17GHVG9kYkar.png',
                'website' => null,
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => 'https://api.whatsapp.com/message/KEXUKLX6XP2TI1?autoload=1&app_absent=0',
                'created_at' => '2025-03-13 16:09:10',
                'updated_at' => '2025-03-15 06:17:14'
            ],
            [
                'id' => 4,
                'name' => 'Day To Days',
                'logo' => 'market/va9yUjhDZ6rgErCH2DwyOtg44QhFCzY6sxkxUTRv.png',
                'website' => 'https://daytodayuae.com',
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => '544555263',
                'created_at' => '2025-03-15 04:59:24',
                'updated_at' => '2025-03-15 06:17:26'
            ],
            [
                'id' => 5,
                'name' => 'Plus Royal Gift',
                'logo' => 'market/Fh67pVEQ7j9d4t94W788fMfZlDG69z7VlmocOcUW.png',
                'website' => 'https://plusgiftroyal.com',
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => '+971509983473',
                'created_at' => '2025-03-15 12:26:36',
                'updated_at' => '2025-03-15 12:26:36'
            ],
            [
                'id' => 6,
                'name' => 'GALA',
                'logo' => 'market/1lciZmELaSte0OarottfPInTOl3ffiR35iMrIj1D.png',
                'website' => 'https://galamarkets.com',
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => '+971562186121',
                'created_at' => '2025-03-15 15:00:17',
                'updated_at' => '2025-03-15 15:00:17'
            ]
        ];

        foreach ($markets as $market) {
            Market::create($market);
        }
    }
} 