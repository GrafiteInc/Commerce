<?php

namespace Grafite\Commerce\Models;

use Grafite\Cms\Models\CmsModel;
use Grafite\Commerce\Models\Order;
use Grafite\Commerce\Models\Refund;

class Transaction extends CmsModel
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
        return $this->belongsTo(Order::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function getAmountAttribute()
    {
        return $this->total;
    }
}
