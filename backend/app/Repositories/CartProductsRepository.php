<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartProducts;

class CartProductsRepository
{
    private CartProducts $model;

    public function __construct( CartProducts $model )
    {
        $this->model = $model;
    }

    public function getProduct(Cart $cart, int $productId): ?CartProducts
    {
        return $cart->products()->where('product_id', $productId)->first();
    }

    public function add(array $attributtes): CartProducts
    {
        return $this->model->create($attributtes);
    }

    public function update(int $id, array $attributtes): void
    {
        $this->model->where('id', $id)->update($attributtes);
    }

    public function remove(int $id): void
    {
        $this->model->where('id', $id)->delete();
    }
}
