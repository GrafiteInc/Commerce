<?php

namespace Yab\Hadron\Models;

use Yab\Hadron\Models\Transactions;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    public $table = "orders";

    public $primaryKey = "id";

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

    public function transaction()
    {
        $transaction = Transactions::find($this->transaction_id);
        return $transaction;
    }

}
