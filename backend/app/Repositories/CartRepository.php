<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class CartRepository
{
    private Cart $model;

    public function __construct( Cart $model )
    {
        $this->model = $model;
    }
    public function getByUserId(int $userId): Cart
    {
        return $this->model->firstOrCreate(['user_id' => $userId]);
    }

    public function getById(int $cartId): Cart
    {
        return $this->model->with([
            'products.product',
            'actions' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'actions.product'
        ])->where('id', $cartId)->first();
    }

    public function getCreatedToday(): Collection
    {
        return $this->model->whereDate('created_at', Carbon::today())->get();
    }

    public function update(int $id, array $attributtes): void
    {
        $this->model->where('id', $id)->update($attributtes);
    }
}
