<?php

namespace App\Providers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Shop\CartService;
use App\Services\Shop\CartAddService;
use App\Services\Shop\CartUpdateService;
use App\Services\Shop\CartRemoveService;
use App\Services\Shop\CartCalculatorService;
use App\Services\Shop\CartActionService;
use App\Services\Shop\UpdateProductQuantityService;
use App\Services\Notifications\LowStockNotificationService;
use App\Services\Notifications\DailySalesReportService;
use App\Repositories\CartRepository;
use App\Repositories\CartProductsRepository;
use App\Repositories\UserRepository;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('CartService', function ($app) {
            return new CartService(
                app('CartAddService'),
                app('CartUpdateService'),
                app('CartRemoveService'),
                $app->make(CartCalculatorService::class),
                $app->make(CartRepository::class),
                $app->make(CartProductsRepository::class)
            );
        });

        $this->app->bind('CartAddService', function ($app) {
            return new CartAddService(
                $app->make(CartActionService::class),
                $app->make(UpdateProductQuantityService::class),
                $app->make(CartProductsRepository::class),
                $app->make(ProductRepository::class)
            );
        });

        $this->app->bind('CartUpdateService', function ($app) {
            return new CartUpdateService(
                $app->make(CartActionService::class),
                $app->make(UpdateProductQuantityService::class),
                $app->make(CartProductsRepository::class),
                $app->make(ProductRepository::class)
            );
        });

        $this->app->bind('CartRemoveService', function ($app) {
            return new CartRemoveService(
                $app->make(CartActionService::class),
                $app->make(UpdateProductQuantityService::class),
                $app->make(CartProductsRepository::class),
                $app->make(ProductRepository::class)
            );
        });

        $this->app->bind('LowStockNotificationService', function ($app) {
            return new LowStockNotificationService(
                $app->make(UserRepository::class),
                $app->make(ProductRepository::class)
            );
        });

        $this->app->bind('DailySalesReportService', function ($app) {
            return new DailySalesReportService(
                $app->make(UserRepository::class),
                $app->make(CartRepository::class)
            );
        });
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
