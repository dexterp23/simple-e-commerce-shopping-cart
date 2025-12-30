<?php

namespace App\Services\Shop;

use App\Repositories\CartProductsRepository;
use App\Repositories\ProductRepository;

class CartAddService implements CartAddServiceInterface
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
        int $productId,
        int $quantity = 0
    ): void {
        $product = $this->productRepository->getById($productId);

        $this->updateProductQuantityService->decrease($product, $quantity);
        $this->cartActionService->handle(
            $cartId,
            $productId,
            config('cart.action.add'),
            $quantity
        );

        $attributtes = [
            'cart_id' => $cartId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'total' => $product->price,
        ];
        $this->cartProductsRepository->add($attributtes);
    }
}
