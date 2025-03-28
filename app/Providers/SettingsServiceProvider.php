<?php

namespace App\Providers;

use App\Services\SettingsService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService();
        });
        
        // Register a 'settings' helper in the app container
        $this->app->singleton('settings', function ($app) {
            return $app->make(SettingsService::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register a Blade directive for easy access to settings
        Blade::directive('setting', function ($expression) {
            return "<?php echo app('settings')->get({$expression}); ?>";
        });
    }
}
