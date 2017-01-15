<?php

namespace Yab\Hadron\Models;

use Yab\Quarx\Models\QuarxModel;

class Transactions extends QuarxModel
{
    public $table = 'transactions';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'provider',
        'state',
        'subtotal',
        'tax',
        'total',
        'shipping',
        'refund_date',
        'refund_requested',
        'provider_id',
        'provider_date',
        'provider_dispute',
        'customer_id',
        'notes',
        'cart',
        'response',
    ];

    public static $rules = [];
}
