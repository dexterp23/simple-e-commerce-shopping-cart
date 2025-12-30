<?php

namespace App\Services\Shop;

use App\Models\Cart;

interface CartCalculatorServiceInterface
{
    public function recalculate(Cart $cart): void;
}
