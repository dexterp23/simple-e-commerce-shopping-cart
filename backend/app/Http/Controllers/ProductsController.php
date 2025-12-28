<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
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

        return Inertia::render('Shop/Products', [
            'products' => $products,
            'filters' => $filters
        ]);
    }
}
