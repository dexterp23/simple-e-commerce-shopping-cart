<?php

namespace App\Repositories;

use App\Models\CartActions;

class CartActionsRepository
{
    private CartActions $model;

    public function __construct( CartActions $model )
    {
        $this->model = $model;
    }

    public function add(array $attributtes): CartActions
    {
        return $this->model->create($attributtes);
    }
}
