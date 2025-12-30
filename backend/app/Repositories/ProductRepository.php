<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{
    private Product $model;

    public function __construct( Product $model )
    {
        $this->model = $model;
    }

    public function getById(int $productId): Product
    {
        return $this->model->where('id', $productId)->first();
    }

    public function getAllPaginated(array $filters): LengthAwarePaginator
    {
        $query = $this->model
            ->when($filters, function ($query, $filters) {
                foreach ($filters as $field => $value) {
                    if (!empty($value)) {
                        switch ($field) {
                            case 'filter_name':
                                $query->where('name', 'like', "%{$value}%");
                                break;
                        }
                    }
                }

            })
            ->orderBy('name', 'asc');
        return $query->paginate(10);
    }
}
