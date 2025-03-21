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
                'local_name' => 'نيستو',
                'logo' => 'market/CE8HGtLP84hRwq35L9rk4NN2GiQN8z3NrDg8NvF3.png',
                'avatar' => 'markets/FfUzCkh85k6XHwnGMHrTe455cJ8XgVkg1JxCrhrb.jpg',
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
                'local_name' => 'لو لو هيبر ماركت',
                'logo' => 'market/nEuCfTYR4QOyXFKB5ErwbE0xzfM5vHNgWObPjAQR.png',
                'avatar' => 'markets/acZXLLfESdHjN1G0pAf4ErEbJfULqjfN4hjQDH4s.jpg',
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
                'local_name' => 'جيفت فيليجز',
                'logo' => 'market/wGlPbJYIogcLQfXLhoriCKk6zGcV17GHVG9kYkar.png',
                'avatar' => 'markets/nTTYQA8DmqVe7dyoRNl9bcIdJdlo1jbTMlfjqhTh.jpg',
                'website' => null,
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => 'https://api.whatsapp.com/message/KEXUKLX6XP2TI1?autoload=1&app_absent=0',
                'created_at' => '2025-03-13 16:09:10',
                'updated_at' => '2025-03-15 06:17:14'
            ],
            [
                'id' => 4,
                'name' => 'Day To Day',
                'local_name' => 'دي تو دي',
                'logo' => 'market/va9yUjhDZ6rgErCH2DwyOtg44QhFCzY6sxkxUTRv.png',
                'avatar' => 'markets/gJJwgJyjPZDQwMIrrJ2ksAUVcefXD8LYe9v3wVAH.jpg',
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
                'local_name' => 'بلاس رويال جيفت',
                'logo' => 'market/Fh67pVEQ7j9d4t94W788fMfZlDG69z7VlmocOcUW.png',
                'avatar' => 'markets/qxnva8sNOCFCvE34OIK6hAzy04nn16pzoYEJrZCN.jpg',
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
                'local_name' => 'جالا',
                'logo' => 'market/1lciZmELaSte0OarottfPInTOl3ffiR35iMrIj1D.png',
                'avatar' => 'markets/4laIroenWXnVhn7Tkrk5gfoPWcnV6JVt8zFVJpNX.jpg',
                'website' => 'https://galamarkets.com',
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => '+971562186121',
                'created_at' => '2025-03-15 15:00:17',
                'updated_at' => '2025-03-15 15:00:17'
            ],
            [
                'id' => 7,
                'name' => 'VIVA',
                'local_name' => 'فيفا',
                'logo' => 'market/RRAUc2UAamxt0Nig8VaHviGRE2t104JrhHex66sX.png',
                'avatar' => 'markets/h4GyZyAO0rLG84uCidWixAmW2AMtmx1yyrSS90Gp.jpg',
                'website' => 'https://myviva.com',
                'android_app_link' => null,
                'ios_app_link' => null,
                'whatsapp' => null,
                'created_at' => '2025-03-15 15:00:17',
                'updated_at' => '2025-03-15 15:00:17'
            ]
        ];

        foreach ($markets as $market) {
            Market::create($market);
        }
    }
} 