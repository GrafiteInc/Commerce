<?php

namespace Quarx\Modules\Hadron\Models;

use Yab\Quarx\Models\QuarxModel;

class Orders extends QuarxModel
{
    public $table = 'orders';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'customer_id',
        'transaction_id',
        'details',
        'shipping_address',
        'is_shipped',
        'tracking_number',
        'notes',
        'status',
    ];

    public static $rules = [];

    public function transaction($key = null)
    {
        $transaction = Transactions::find($this->transaction_id);

        if (!is_null($key)) {
            return $transaction->$key;
        }

        return $transaction;
    }

    public function shippingAddress($key = null)
    {
        $address = json_decode($this->shipping_address);

        if (isset($address->$key)) {
            return $address->$key;
        }

        return $address;
    }
}
