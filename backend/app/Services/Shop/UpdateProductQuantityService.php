<?php

namespace App\Services\Shop;

use App\Models\Product;
use App\Repositories\ProductRepository;
use InvalidArgumentException;

class UpdateProductQuantityService implements UpdateProductQuantityServiceInterface
{
    protected ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository,
    )
    {
        $this->productRepository = $productRepository;
    }

    public function decrease(Product $product, int $quantity): void
    {
        if ($product->stock_quantity < $quantity) {
            throw new InvalidArgumentException('Not enough stock.');
        }

        $product->decrement('stock_quantity', $quantity);
    }

    public function increase(Product $product, int $quantity): void
    {
        $product->increment('stock_quantity', $quantity);
    }
}
