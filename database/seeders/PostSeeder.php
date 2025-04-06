<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Market;
use App\Models\Branch;

class PostSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'offer@roniplus.ae')->first();
        $market = Market::first();
        $branch = Branch::first();

        $posts = [
            [
                'title' => 'Top 10 Shopping Tips for Dubai Markets',
                'slug' => 'top-10-shopping-tips-dubai-markets',
                'excerpt' => 'Discover the best shopping strategies and insider tips for navigating Dubai\'s vibrant markets and getting the best deals.',
                'content' => '<p>Dubai\'s markets are a treasure trove of opportunities, but navigating them effectively requires some insider knowledge. Here are our top 10 tips for successful shopping in Dubai markets:</p>
                <h2>1. Timing is Everything</h2>
                <p>Visit markets early in the morning or late in the evening to avoid the midday heat and crowds.</p>
                <h2>2. Do Your Research</h2>
                <p>Before visiting any market, research the typical prices and available products to avoid overpaying.</p>
                <h2>3. Bargain Wisely</h2>
                <p>Haggling is expected in many markets, but do it respectfully and know when to stop.</p>
                <h2>4. Check Product Quality</h2>
                <p>Always inspect items carefully before purchase, especially for electronics and clothing.</p>
                <h2>5. Know Your Rights</h2>
                <p>Familiarize yourself with consumer protection laws and return policies.</p>
                <h2>6. Stay Hydrated</h2>
                <p>Keep water with you and take regular breaks in air-conditioned areas.</p>
                <h2>7. Use Cash Wisely</h2>
                <p>While cards are widely accepted, having cash can help with bargaining and smaller purchases.</p>
                <h2>8. Dress Appropriately</h2>
                <p>Respect local customs and dress modestly when visiting traditional markets.</p>
                <h2>9. Plan Your Route</h2>
                <p>Map out your shopping route to maximize time and minimize walking.</p>
                <h2>10. Keep Records</h2>
                <p>Save receipts and take photos of important purchases for warranty purposes.</p>',
                'image_url' => '/storage/blog_images/qWEIKwx6VinGHCbleuMKyvO4ZWzB8KrW0azHhNCj.webp',
                'meta_title' => 'Top 10 Shopping Tips for Dubai Markets | Expert Guide',
                'meta_description' => 'Learn the best shopping strategies and insider tips for navigating Dubai\'s vibrant markets and getting the best deals.',
                'is_active' => true,
                'scope' => 'global'
            ],
            [
                'title' => 'The Ultimate Guide to Seasonal Sales in Dubai',
                'slug' => 'ultimate-guide-seasonal-sales-dubai',
                'excerpt' => 'Everything you need to know about Dubai\'s major sales seasons, including Dubai Shopping Festival, Summer Surprises, and more.',
                'content' => '<p>Dubai is famous for its spectacular shopping festivals and seasonal sales. Here\'s your comprehensive guide to making the most of these shopping extravaganzas:</p>
                <h2>Dubai Shopping Festival (DSF)</h2>
                <p>Held annually from December to January, DSF is the city\'s biggest shopping event.</p>
                <h2>Dubai Summer Surprises</h2>
                <p>Running from July to August, this event offers amazing deals to beat the summer heat.</p>
                <h2>Eid Sales</h2>
                <p>Both Eid Al-Fitr and Eid Al-Adha bring special promotions and extended shopping hours.</p>
                <h2>Black Friday</h2>
                <p>November brings massive discounts across all major retailers.</p>
                <h2>White Day</h2>
                <p>March brings special promotions on electronics and home appliances.</p>',
                'image_url' => '/storage/blog_images/Xpjpy8CIN5h75X1y1QR6q7ayQs2GYG8s9rIU2jKG.webp',
                'meta_title' => 'The Ultimate Guide to Seasonal Sales in Dubai | Shopping Calendar',
                'meta_description' => 'Complete guide to Dubai\'s major sales seasons, including Dubai Shopping Festival, Summer Surprises, and other shopping events.',
                'is_active' => true,
                'scope' => 'global'
            ],
            [
                'title' => 'Hidden Gems: Local Markets You Need to Visit',
                'slug' => 'hidden-gems-local-markets-dubai',
                'excerpt' => 'Explore lesser-known markets in Dubai that offer unique shopping experiences and authentic local products.',
                'content' => '<p>Beyond the glitzy malls, Dubai is home to several hidden market gems that offer authentic shopping experiences:</p>
                <h2>Deira Spice Souk</h2>
                <p>Experience the aromatic world of spices and traditional goods.</p>
                <h2>Textile Souk</h2>
                <p>Find beautiful fabrics and traditional clothing at great prices.</p>
                <h2>Gold Souk</h2>
                <p>Browse through stunning gold jewelry and precious metals.</p>
                <h2>Fruit and Vegetable Market</h2>
                <p>Fresh produce and local specialties at wholesale prices.</p>',
                'image_url' => '/storage/blog_images/BoR0qaKOsTUDx1xay5vWJJk6XlopZemAVXsQVzhh.webp',
                'meta_title' => 'Hidden Gems: Local Markets in Dubai | Off-the-Beaten-Path Shopping',
                'meta_description' => 'Discover lesser-known markets in Dubai offering unique shopping experiences and authentic local products.',
                'is_active' => true,
                'scope' => 'global'
            ],
            [
                'title' => 'Smart Shopping: How to Compare Prices Effectively',
                'slug' => 'smart-shopping-compare-prices',
                'excerpt' => 'Learn effective strategies for comparing prices across different markets and getting the best value for your money.',
                'content' => '<p>Smart shopping is an art that can save you significant money. Here\'s how to master price comparison:</p>
                <h2>Use Price Comparison Apps</h2>
                <p>Leverage technology to track prices across different stores.</p>
                <h2>Check Online vs Offline</h2>
                <p>Compare prices between online and physical stores.</p>
                <h2>Track Price History</h2>
                <p>Monitor price changes over time to identify the best time to buy.</p>
                <h2>Consider Total Cost</h2>
                <p>Factor in shipping, warranties, and other additional costs.</p>',
                'image_url' => '/storage/blog_images/lR813lip0m0xIG2HQzGkI4zoNWqYdZgsHUMhFd4P.webp',
                'meta_title' => 'Smart Shopping: Price Comparison Guide | Save Money in Dubai',
                'meta_description' => 'Learn effective strategies for comparing prices across different markets and getting the best value for your money.',
                'is_active' => true,
                'scope' => 'global'
            ],
            [
                'title' => 'Eco-Friendly Shopping in Dubai',
                'slug' => 'eco-friendly-shopping-dubai',
                'excerpt' => 'Discover sustainable shopping options and eco-friendly markets in Dubai that promote environmental consciousness.',
                'content' => '<p>Dubai is embracing sustainable shopping practices. Here\'s how you can shop eco-consciously:</p>
                <h2>Local Produce Markets</h2>
                <p>Support local farmers and reduce carbon footprint.</p>
                <h2>Second-Hand Markets</h2>
                <p>Find unique items while promoting sustainability.</p>
                <h2>Eco-Friendly Products</h2>
                <p>Discover stores offering sustainable alternatives.</p>
                <h2>Recycling Initiatives</h2>
                <p>Learn about Dubai\'s recycling programs and how to participate.</p>',
                'image_url' => '/storage/blog_images/CvAuHDZAY0Jw9Lf2g50Kl8rNv5p1y35ptV3Qbot5.webp',
                'meta_title' => 'Eco-Friendly Shopping in Dubai | Sustainable Shopping Guide',
                'meta_description' => 'Discover sustainable shopping options and eco-friendly markets in Dubai that promote environmental consciousness.',
                'is_active' => true,
                'scope' => 'global'
            ],
            [
                'title' => 'Digital Shopping: The Future of Retail in Dubai',
                'slug' => 'digital-shopping-future-retail-dubai',
                'excerpt' => 'Explore how technology is transforming the shopping experience in Dubai, from virtual try-ons to AI-powered recommendations.',
                'content' => '<p>Dubai\'s retail landscape is evolving with digital innovation:</p>
                <h2>Virtual Shopping Experiences</h2>
                <p>Try products virtually before purchase.</p>
                <h2>AI Shopping Assistants</h2>
                <p>Get personalized recommendations and assistance.</p>
                <h2>Digital Payment Solutions</h2>
                <p>Explore new payment methods and digital wallets.</p>
                <h2>Smart Shopping Apps</h2>
                <p>Discover apps that enhance your shopping experience.</p>',
                'image_url' => '/storage/blog_images/HYdTGQcyiGeETix0RfcxsHlVKDiGX8JyCoHMs6pp.webp',
                'meta_title' => 'Digital Shopping: The Future of Retail in Dubai | Tech Shopping Guide',
                'meta_description' => 'Explore how technology is transforming the shopping experience in Dubai, from virtual try-ons to AI-powered recommendations.',
                'is_active' => true,
                'scope' => 'global'
            ]
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'slug' => $post['slug'],
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'image_url' => $post['image_url'],
                'meta_title' => $post['meta_title'],
                'meta_description' => $post['meta_description'],
                'is_active' => $post['is_active'],
                'author_id' => $admin->id,
                'market_id' => $market->id,
                'branch_id' => $branch->id,
                'scope' => $post['scope']
            ]);
        }
    }
} 