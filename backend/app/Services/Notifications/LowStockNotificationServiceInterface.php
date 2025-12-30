<?php

namespace App\Services\Notifications;

interface LowStockNotificationServiceInterface
{
    public function handle(int $productId): void;
}
