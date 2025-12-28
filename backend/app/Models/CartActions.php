<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartActions extends Model
{
    use SoftDeletes;

    protected $table = 'cart_action';

    protected $fillable = [
        'cart_id',
        'product_id',
        'action',
        'quantity',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
