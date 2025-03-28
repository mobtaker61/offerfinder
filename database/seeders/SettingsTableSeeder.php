<?php

namespace Database\Seeders;

use App\Models\SettingSchema;
use App\Services\SettingsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settingsService = app(SettingsService::class);
        
        // Create general settings
        $this->createSetting(
            $settingsService,
            'site.name',
            'Site Name',
            'The name of your site that will be displayed in various places',
            'general',
            'string',
            null,
            'Offer Finder',
            1
        );
        
        $this->createSetting(
            $settingsService,
            'site.description',
            'Site Description',
            'A short description of your site for SEO purposes',
            'general',
            'text',
            null,
            'Find the best offers and deals in your area',
            2
        );
        
        // Create appearance settings
        $this->createSetting(
            $settingsService,
            'appearance.logo',
            'Site Logo',
            'The logo displayed in the header of your site',
            'appearance',
            'image',
            null,
            null,
            1
        );
        
        $this->createSetting(
            $settingsService,
            'appearance.favicon',
            'Favicon',
            'The small icon displayed in browser tabs',
            'appearance',
            'image',
            null,
            null,
            2
        );
        
        $this->createSetting(
            $settingsService,
            'appearance.primary_color',
            'Primary Color',
            'The main color used throughout the site (Hex code)',
            'appearance',
            'string',
            null,
            '#3490dc',
            3
        );
        
        // Create contact settings
        $this->createSetting(
            $settingsService,
            'contact.email',
            'Contact Email',
            'The email address displayed on the contact page',
            'contact',
            'email',
            null,
            'contact@example.com',
            1
        );
        
        $this->createSetting(
            $settingsService,
            'contact.phone',
            'Contact Phone',
            'The phone number displayed on the contact page',
            'contact',
            'string',
            null,
            '+1 (555) 123-4567',
            2
        );
        
        $this->createSetting(
            $settingsService,
            'contact.address',
            'Contact Address',
            'The physical address displayed on the contact page',
            'contact',
            'text',
            null,
            '123 Main St, City, Country',
            3
        );
        
        // Create social media settings
        $this->createSetting(
            $settingsService,
            'social.facebook',
            'Facebook URL',
            'The URL to your Facebook page',
            'social',
            'url',
            null,
            'https://facebook.com/',
            1
        );
        
        $this->createSetting(
            $settingsService,
            'social.twitter',
            'Twitter URL',
            'The URL to your Twitter profile',
            'social',
            'url',
            null,
            'https://twitter.com/',
            2
        );
        
        $this->createSetting(
            $settingsService,
            'social.instagram',
            'Instagram URL',
            'The URL to your Instagram profile',
            'social',
            'url',
            null,
            'https://instagram.com/',
            3
        );
        
        // Create currency settings
        $this->createSetting(
            $settingsService,
            'system.currency',
            'Default Currency',
            'The default currency used for all monetary values',
            'system',
            'select',
            json_encode([
                'AED' => 'UAE Dirham (AED)',
                'USD' => 'US Dollar (USD)',
                'EUR' => 'Euro (EUR)',
                'GBP' => 'British Pound (GBP)',
                'IRR' => 'Iranian Rial (IRR)'
            ]),
            'AED',
            1
        );
        
        // Create language settings
        $this->createSetting(
            $settingsService,
            'system.language',
            'Default Language',
            'The default language for the website content',
            'system',
            'select',
            json_encode([
                'en' => 'English',
                'ar' => 'Arabic',
                'fa' => 'Persian'
            ]),
            'en',
            2
        );
        
        // Create notification settings
        $this->createSetting(
            $settingsService,
            'notifications.enable_email',
            'Enable Email Notifications',
            'Whether to send email notifications to users',
            'notifications',
            'boolean',
            null,
            true,
            1
        );
        
        $this->createSetting(
            $settingsService,
            'notifications.enable_push',
            'Enable Push Notifications',
            'Whether to send push notifications to users',
            'notifications',
            'boolean',
            null,
            true,
            2
        );
    }
    
    /**
     * Helper function to create a setting
     */
    private function createSetting(
        SettingsService $service,
        string $key,
        string $label,
        ?string $description,
        string $group,
        string $dataType,
        ?string $options,
        $defaultValue,
        int $displayOrder
    ): void {
        $schema = $service->createSchema([
            'key' => $key,
            'label' => $label,
            'description' => $description,
            'group' => $group,
            'data_type' => $dataType,
            'options' => $options,
            'default_value' => is_bool($defaultValue) ? ($defaultValue ? '1' : '0') : $defaultValue,
            'is_required' => false,
            'display_order' => $displayOrder,
            'is_active' => true
        ]);
        
        if ($schema && $defaultValue !== null) {
            $service->set($key, is_bool($defaultValue) ? ($defaultValue ? '1' : '0') : $defaultValue);
        }
    }
}
