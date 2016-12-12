<?php

namespace Yab\Hadron\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public $table = 'orders';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'transaction_id',
        'details',
        'shipping',
        'is_shipped',
        'shipping_address',
    ];

    public static $rules = [

    ];

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
