<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProductsController extends Controller
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    public function index(Request $request): \Inertia\Response
    {
        $filters = $request->all();
        $products = $this->productRepository->getAllPaginated($filters);

        return Inertia::render('Shop/Products', [
            'flash' => [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
                'info' => Session::get('info')
            ],
            'products' => $products,
            'filters' => $filters
        ]);
    }
}
