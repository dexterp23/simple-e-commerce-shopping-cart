<?php

namespace App\Services\Shop;

use App\Models\CartProducts;
use App\Repositories\CartProductsRepository;
use App\Repositories\ProductRepository;

class CartUpdateService implements CartUpdateServiceInterface
{
    protected CartActionServiceInterface $cartActionService;
    protected UpdateProductQuantityServiceInterface $updateProductQuantityService;
    protected CartProductsRepository $cartProductsRepository;
    protected ProductRepository $productRepository;

    public function __construct(
        CartActionServiceInterface $cartActionService,
        UpdateProductQuantityServiceInterface $updateProductQuantityService,
        CartProductsRepository $cartProductsRepository,
        ProductRepository $productRepository
    )
    {
        $this->cartActionService = $cartActionService;
        $this->updateProductQuantityService = $updateProductQuantityService;
        $this->cartProductsRepository = $cartProductsRepository;
        $this->productRepository = $productRepository;
    }

    public function handle(
        int $cartId,
        CartProducts $cartProduct,
        int $quantity = 0
    ): void {
        $product = $this->productRepository->getById($cartProduct->product_id);

        $oldQuantity = $cartProduct->quantity;
        $difference = $quantity - $oldQuantity;

        if ($difference > 0) {
            $this->updateProductQuantityService->decrease($product, $difference);
        }

        if ($difference < 0) {
            $this->updateProductQuantityService->increase($product, abs($difference));
        }

        $this->cartActionService->handle(
            $cartId,
            $cartProduct->product_id,
            config('cart.action.update'),
            $quantity
        );

        $attributtes = [
            'quantity' => $quantity,
            'total' => $product->price * $quantity,
        ];
        $this->cartProductsRepository->update($cartProduct->id, $attributtes);
    }
}
