<?php

namespace App\Services\Shop;

use App\Models\Cart;
use App\Repositories\CartRepository;
use App\Repositories\CartProductsRepository;
use Illuminate\Support\Facades\Auth;

class CartService implements CartServiceInterface
{
    protected Cart $cart;
    protected CartAddServiceInterface $cartAddService;
    protected CartUpdateServiceInterface $cartUpdateService;
    protected CartRemoveServiceInterface $cartRemoveService;
    protected CartCalculatorServiceInterface $cartCalculatorService;
    protected CartRepository $cartRepository;
    protected CartProductsRepository $cartProductsRepository;

    public function __construct(
        CartAddServiceInterface $cartAddService,
        CartUpdateServiceInterface $cartUpdateService,
        CartRemoveServiceInterface $cartRemoveService,
        CartCalculatorServiceInterface $cartCalculatorService,
        CartRepository $cartRepository,
        CartProductsRepository $cartProductsRepository
    )
    {
        $this->cartAddService = $cartAddService;
        $this->cartUpdateService = $cartUpdateService;
        $this->cartRemoveService = $cartRemoveService;
        $this->cartCalculatorService = $cartCalculatorService;
        $this->cartRepository = $cartRepository;
        $this->cartProductsRepository = $cartProductsRepository;
        $this->setCart();
    }

    public function add(int $productId, int $quantity = 0): void
    {
        $this->addOrUpdate($productId, $quantity, true);
    }

    public function update(int $productId, int $quantity = 0): void
    {
        $this->addOrUpdate($productId, $quantity, false);
    }

    protected function addOrUpdate(
        int $productId,
        int $quantity = 0,
        bool $increment = false
    ): void {
        $cart = $this->getCart();
        $cartProduct = $this->cartProductsRepository->getProduct($cart, $productId);

        $finalQuantity = $quantity;
        if ($cartProduct && $increment) {
            $finalQuantity += $cartProduct->quantity;
        }

        if ($cartProduct) {
            $this->cartUpdateService->handle($cart->id, $cartProduct, $finalQuantity);
        } else {
            $this->cartAddService->handle($cart->id, $productId, $finalQuantity);
        }
        $this->cartCalculatorService->recalculate($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getCart();
        $cartProduct = $this->cartProductsRepository->getProduct($cart, $productId);
        $this->cartRemoveService->handle($cart->id, $cartProduct);
        $this->cartCalculatorService->recalculate($cart);
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(): void
    {
        $userId = Auth::id();
        $this->cart = $this->cartRepository->getByUserId($userId);
    }
}
