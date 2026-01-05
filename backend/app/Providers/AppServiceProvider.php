<?php

namespace App\Providers;

use App\Models\Product;
use App\Services\Notifications\LowStockNotificationServiceInterface;
use App\Services\Shop\CartActionServiceInterface;
use App\Services\Shop\CartAddServiceInterface;
use App\Services\Shop\CartCalculatorServiceInterface;
use App\Services\Shop\CartRemoveServiceInterface;
use App\Services\Shop\CartService;
use App\Services\Shop\CartAddService;
use App\Services\Shop\CartServiceInterface;
use App\Services\Shop\CartUpdateService;
use App\Services\Shop\CartRemoveService;
use App\Services\Shop\CartCalculatorService;
use App\Services\Shop\CartActionService;
use App\Services\Shop\CartUpdateServiceInterface;
use App\Services\Shop\UpdateProductQuantityService;
use App\Services\Notifications\LowStockNotificationService;
use App\Services\Notifications\DailySalesReportService;
use App\Services\Notifications\DailySalesReportServiceInterface;
use App\Observers\ProductObserver;
use App\Services\Shop\UpdateProductQuantityServiceInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CartServiceInterface::class,
            CartService::class
        );
        $this->app->bind(
            CartAddServiceInterface::class,
            CartAddService::class
        );
        $this->app->bind(
            CartActionServiceInterface::class,
            CartActionService::class
        );
        $this->app->bind(
            UpdateProductQuantityServiceInterface::class,
            UpdateProductQuantityService::class
        );
        $this->app->bind(
            CartUpdateServiceInterface::class,
            CartUpdateService::class
        );
        $this->app->bind(
            CartRemoveServiceInterface::class,
            CartRemoveService::class
        );
        $this->app->bind(
            CartCalculatorServiceInterface::class,
            CartCalculatorService::class
        );
        $this->app->bind(
            DailySalesReportServiceInterface::class,
            DailySalesReportService::class
        );
        $this->app->bind(
            LowStockNotificationServiceInterface::class,
            LowStockNotificationService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Product::observe(ProductObserver::class);
    }
}
