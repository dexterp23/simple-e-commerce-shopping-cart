<?php

namespace App\Services\Shop;

use App\Models\CartProducts;

interface CartRemoveServiceInterface
{
    public function handle(int $cartId, CartProducts $cartProduct): void;
}
