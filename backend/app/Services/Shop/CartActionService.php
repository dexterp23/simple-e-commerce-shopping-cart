<?php

namespace App\Services\Shop;

use App\Models\CartActions;
use App\Repositories\CartActionsRepository;

class CartActionService implements CartActionServiceInterface
{
    protected CartActionsRepository $cartActionsRepository;

    public function __construct(
        CartActionsRepository $cartActionsRepository,
    )
    {
        $this->cartActionsRepository = $cartActionsRepository;
    }

    public function handle(
        int $cartId,
        int $productId,
        string $action,
        int $quantity = 0
    ): CartActions {
        $attributtes = [
            'cart_id' => $cartId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'action' => $action,
        ];
        return $this->cartActionsRepository->add($attributtes);
    }
}
