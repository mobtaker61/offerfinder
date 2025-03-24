<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Market;
use Illuminate\Support\Str;

class GenerateMarketSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'markets:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing markets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating slugs for existing markets...');

        Market::chunk(100, function ($markets) {
            foreach ($markets as $market) {
                $market->slug = Str::slug($market->name);
                $market->save();
                $this->line("Generated slug for market: {$market->name} -> {$market->slug}");
            }
        });

        $this->info('All market slugs have been generated!');
        
        return Command::SUCCESS;
    }
}
