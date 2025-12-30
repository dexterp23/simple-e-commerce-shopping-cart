<?php

namespace App\Services\Shop;

use App\Models\CartProducts;
use App\Repositories\CartProductsRepository;
use App\Repositories\ProductRepository;

class CartRemoveService implements CartRemoveServiceInterface
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

    public function handle(int $cartId, CartProducts $cartProduct): void
    {
        $product = $this->productRepository->getById($cartProduct->product_id);
        $this->updateProductQuantityService->increase($product, $cartProduct->quantity);

        $this->cartActionService->handle(
            $cartId,
            $cartProduct->product_id,
            config('cart.action.remove'),
            $cartProduct->quantity
        );

        $this->cartProductsRepository->remove($cartProduct->id);
    }
}
