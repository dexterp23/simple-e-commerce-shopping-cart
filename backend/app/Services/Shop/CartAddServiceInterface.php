<?php

namespace App\Services\Shop;

interface CartAddServiceInterface
{
    public function handle(int $cartId, int $productId, int $quantity = 0): void;
}
