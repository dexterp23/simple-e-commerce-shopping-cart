<?php

namespace App\Services\Shop;

use App\Models\Cart;
use App\Repositories\CartRepository;

class CartCalculatorService implements CartCalculatorServiceInterface
{
    protected CartRepository $cartRepository;

    public function __construct(
        CartRepository $cartRepository
    )
    {
        $this->cartRepository = $cartRepository;
    }

    public function recalculate(Cart $cart): void
    {
        $total = $cart->products()
            ->get()
            ->sum(fn ($item) => $item->quantity * $item->product->price);

        $this->cartRepository->update($cart->id, ['total' => $total]);
    }
}
