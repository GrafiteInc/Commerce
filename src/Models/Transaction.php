<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;
use Yab\Quazar\Models\Order;
use Yab\Quazar\Models\Refund;

class Transaction extends QuarxModel
{
    public $table = 'transactions';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'provider',
        'state',
        'subtotal',
        'coupon',
        'tax',
        'total',
        'shipping',
        'refund_date',
        'refund_requested',
        'provider_id',
        'provider_date',
        'provider_dispute',
        'user_id',
        'notes',
        'cart',
        'response',
    ];

    public static $rules = [];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    /**
     * Get the full transaction amount, in cents
     * 
     */
    public function getAmountAttribute()
    {
        return $this->total * 100;
    }
}
