<?php

namespace App\Console\Commands;

use App\Models\Market;
use App\Models\Offer;
use App\Models\Page;
use App\Models\Branch;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // Add static pages
        $sitemap->add(Url::create('/')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1.0));

        // Add dynamic pages
        Page::where('is_active', true)->get()->each(function (Page $page) use ($sitemap) {
            $sitemap->add(Url::create("/pages/{$page->slug}")
                ->setLastModificationDate($page->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8));
        });

        // Add markets
        Market::all()->each(function (Market $market) use ($sitemap) {
            $sitemap->add(Url::create("/market/{$market->id}")
                ->setLastModificationDate($market->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.9));
        });

        // Add branches
        Branch::with('market')->get()->each(function (Branch $branch) use ($sitemap) {
            $sitemap->add(Url::create("/branch/{$branch->id}")
                ->setLastModificationDate($branch->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7));
        });

        // Add static pages
        $pages = Page::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        foreach ($pages as $page) {
            $sitemap->add(
                Url::create(route('pages.show', $page->slug))
                    ->setLastModificationDate($page->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }

        // Add non-expired offers
        Offer::where('end_date', '>=', now())
            ->orderBy('end_date')
            ->get()
            ->each(function (Offer $offer) use ($sitemap) {
                $sitemap->add(Url::create("/offer/{$offer->id}")
                    ->setLastModificationDate($offer->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9));
            });

        // Add listing pages
        $sitemap->add(Url::create('/market')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.8));

        $sitemap->add(Url::create('/offers')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.8));

        // Add location-based pages
        $sitemap->add(Url::create('/emirates')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));

        // Store the sitemap
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
