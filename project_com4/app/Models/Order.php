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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_user', 'id_user');
    }
}
