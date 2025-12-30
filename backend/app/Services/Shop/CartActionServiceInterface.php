<?php

namespace App\Services\Shop;

use App\Models\CartActions;

interface CartActionServiceInterface
{
    public function handle(int $cartId, int $productId, string $action, int $quantity = 0): CartActions;
}
