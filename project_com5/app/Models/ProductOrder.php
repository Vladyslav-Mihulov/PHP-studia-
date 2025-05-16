<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'product_order';
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'order_id_order',
        'product_id_product',
        'quantity',
        'price',
    ];
    
    public function product()
    {
    return $this->belongsTo(Product::class, 'product_id_product', 'id_product');
    }
}
