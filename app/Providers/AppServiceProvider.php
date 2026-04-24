<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\URL::formatPathUsing(function ($path) {
            if (str_starts_with($path, 'storage/')) {
                return str_replace('storage/', '', $path);
            }
            return $path;
        });

        if (config('app.asset_url')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.asset_url'));
        }

        if (config('filesystems.default') === 's3') {
            URL::forceRootUrl(config('filesystems.disks.s3.url'));
        }
    }
}
