<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $products = $this->productRepository->getAllPaginated($filters);

        return Inertia::render('Shop/Cart', [
            'flash' => [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
                'info' => Session::get('info')
            ],
            'products' => $products,
            'filters' => $filters
        ]);
    }

    public function add(Request $request)
    {
        $productId = $request->get('product_id');

        \Log::info($productId);

        session()->flash('success', __('Successfully added.'));
        session()->flash('error', __('Error Message.'));
        return Inertia::location(route('cart'));
    }
}
