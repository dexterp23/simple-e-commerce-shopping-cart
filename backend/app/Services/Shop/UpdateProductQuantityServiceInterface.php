<?php

namespace App\Services\Shop;

use App\Models\Product;

interface UpdateProductQuantityServiceInterface
{
    public function decrease(Product $product, int $quantity): void;

    public function increase(Product $product, int $quantity): void;
}
