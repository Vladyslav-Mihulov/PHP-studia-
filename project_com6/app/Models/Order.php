<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $incrementing = true;
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'status',
        'date_order',
        'date_end_order',
        'user_id_user',
        'total_price'
    ];
     protected $casts = [
        'date_order' => 'datetime',
        'date_end_order' => 'datetime',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_user', 'id_user');
    }
    
    public function productOrders()
    {
    return $this->hasMany(ProductOrder::class, 'order_id_order', 'id_order');
    }

}
