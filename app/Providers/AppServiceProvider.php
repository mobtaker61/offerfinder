<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Share location data with all views
        view()->composer('*', function ($view) {
            $emirates = \App\Models\Emirate::with(['districts.neighbours'])->get();
            $locationData = [];
            
            foreach ($emirates as $emirate) {
                $locationData[$emirate->name] = [];
                foreach ($emirate->districts as $district) {
                    $locationData[$emirate->name][$district->name] = $district->neighbours->map(function($neighbour) {
                        return [
                            'name' => $neighbour->name,
                            'lat' => $neighbour->latitude,
                            'lng' => $neighbour->longitude
                        ];
                    })->toArray();
                }
            }
            
            $view->with('locationData', $locationData);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
