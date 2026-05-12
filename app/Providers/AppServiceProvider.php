<?php

namespace App\Providers;

use App\Events\InterestSent;
use App\Listeners\SendInterestEmail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $listen = [
        InterestSent::class => [
            SendInterestEmail::class,
        ],
    ];
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
    }
}
