<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;

class Refund extends QuarxModel
{
    public $table = 'refunds';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'transaction_id',
        'order_item_id',
        'provider_id',
        'provider',
        'uuid',
        'amount',
        'charge',
        'currency',
    ];

    public static $rules = [];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
