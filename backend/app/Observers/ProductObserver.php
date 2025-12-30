<?php

namespace App\Observers;

use App\Models\Product;
use App\Jobs\LowStockNotificationJob;

class ProductObserver
{
    public function updated(Product $product): void
    {
        $dirty = $product->getDirty();
        if ($dirty['stock_quantity'] <= config('cart.low_stock_notification_number')) {
            LowStockNotificationJob::dispatch($product->id)->onQueue('LowStockNotif');
        }
    }
}
