<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;

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
}
