<?php

namespace App\Applocation\Providers;

use App\Domain\Product\Services\Backend\ProductService;
use App\Domain\Product\Strategy\ExportDataStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('ProductService', ProductService::class);
        $this->app->bind('ExportDataStrategy', ExportDataStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
