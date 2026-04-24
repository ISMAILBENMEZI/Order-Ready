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

        if (config('filesystems.default') === 's3') {
            URL::forceRootUrl(config('filesystems.disks.s3.url'));
        }

        if (!app()->isLocal()) {
            URL::formatHostUsing(function ($root, $path) {
                if (Str::startsWith($path, 'storage/')) {
                    $newPath = Str::replaceFirst('storage/', '', $path);
                    return config('app.asset_url') . '/' . $newPath;
                }
                return $root;
            });
        }
    }
}
