<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Services\Shop\CartServiceInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected CartRepository $cartRepository;
    protected CartServiceInterface $cartService;

    public function __construct(
        CartRepository $cartRepository,
        CartServiceInterface $cartService
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
    }

    public function index(): \Inertia\Response
    {
        $cart = $this->cartService->getCart();
        $cart = $this->cartRepository->getById($cart->id);

        return Inertia::render('Shop/Cart', [
            'flash' => [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
                'info' => Session::get('info')
            ],
            'products' => $cart->products ?? [],
            'total' => $cart->total ?? 0,
            'actions' => $cart->actions ?? [],
        ]);
    }

    public function add(Request $request, int $productId): Response
    {
        return $this->handleCartAction($request, $productId, 'add');
    }

    public function update(Request $request, int $productId): Response
    {
        return $this->handleCartAction($request, $productId, 'update');
    }

    protected function handleCartAction(Request $request, int $productId, string $action): Response
    {
        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1'],
            ]);

            $quantity = $validated['quantity'];

            match ($action) {
                'add' => $this->cartService->add($productId, $quantity),
                'update' => $this->cartService->update($productId, $quantity),
                default => throw new \InvalidArgumentException('Invalid cart action'),
            };

            session()->flash('success', __($action === 'add' ? 'Successfully added.' : 'Successfully updated.'));
            return Inertia::location(route('cart'));
        } catch (\Exception $exception) {
            session()->flash('error', __($exception->getMessage()));
            return redirect()->back();
        }
    }

    public function remove(int $productId): Response
    {
        try {
            $this->cartService->remove($productId);
            session()->flash('success', __('Successfully removed.'));
            return Inertia::location(route('cart'));
        } catch (\Exception $exception) {
            session()->flash('error', __($exception->getMessage()));
            return redirect()->back();
        }
    }
}
