<?php

namespace App\Services\Shop;

use App\Models\CartProducts;

interface CartUpdateServiceInterface
{
    public function handle(int $cartId, CartProducts $cartProduct, int $quantity = 0): void;
}
