<?php

namespace Sitec\Commerce\Models;

use Sitec\Cms\Models\CmsModel;
use Sitec\Commerce\Models\OrderItem;

class Refund extends CmsModel
{
    public $table = 'refunds';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'transaction_id',
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

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class);
    }

    public function getAmountAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
