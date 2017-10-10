<?php

namespace Yab\Quazar\Models;

use App\Models\User;
use Yab\Quarx\Models\QuarxModel;
use Yab\Quazar\Models\OrderItem;

class Order extends QuarxModel
{
    public $table = 'orders';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'user_id',
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
        $transaction = Transaction::find($this->transaction_id);

        if (!is_null($transaction) && !is_null($key)) {
            return $transaction->$key;
        }

        return $transaction;
    }

    public function hasRefundedOrderItems()
    {
        if ($this->items->where('was_refunded', true)->count() > 0) {
            return true;
        }

        return false;
    }

    public function hasActiveOrderItems()
    {
        if ($this->items->where('was_refunded', false)->count() > 0) {
            return true;
        }

        return false;
    }

    public function remainingValue()
    {
        $refundedValue = 0;

        foreach ($this->items->where('was_refunded', true) as $item) {
            $refundedValue += $item->total;
        }

        return (($this->transaction('total') - $refundedValue) * 100);
    }

    public function shippingAddress($key = null)
    {
        $address = json_decode($this->shipping_address);

        if (isset($address->$key)) {
            return $address->$key;
        }

        return $address;
    }

    /**
     * Get the corresponding OrderItems
     *
     * @return Relationship
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Determine the user that made this order
     * 
     * @return Relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
