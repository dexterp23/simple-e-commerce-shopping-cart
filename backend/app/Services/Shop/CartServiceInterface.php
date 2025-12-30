<?php

namespace App\Services\Shop;

use App\Models\Cart;

interface CartServiceInterface
{
    public function add(int $productId, int $quantity = 0): void;

    public function update(int $productId, int $quantity = 0): void;

    public function remove(int $productId): void;

    public function getCart(): Cart;

    public function setCart(): void;
}
