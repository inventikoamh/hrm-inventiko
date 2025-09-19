<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only configure mail settings if we're not in console or if settings table exists
        if (!$this->app->runningInConsole() || $this->settingsTableExists()) {
            try {
                Setting::configureMailSettings();
            } catch (\Exception $e) {
                // Silently fail if settings table doesn't exist yet
                // This prevents errors during migrations
            }
        }
    }
    
    /**
     * Check if settings table exists
     */
    private function settingsTableExists(): bool
    {
        try {
            return \Schema::hasTable('settings');
        } catch (\Exception $e) {
            return false;
        }
    }
}