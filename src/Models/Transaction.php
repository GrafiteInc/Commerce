<?php

namespace Sitec\Commerce\Models;

use Sitec\Cms\Models\CmsModel;
use Sitec\Commerce\Models\Order;
use Sitec\Commerce\Models\Refund;

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
        return $this->hasOne(Order::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function getStateAttribute($value)
    {
        return ucfirst($value);
    }

    public function getAmountAttribute()
    {
        return $this->total;
    }

    public function getTotalAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getTaxAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getShippingAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getSubtotalAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
