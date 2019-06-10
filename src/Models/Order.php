<?php

namespace SierraTecnologia\Commerce\Models;

use App\Models\User;
use SierraTecnologia\Cms\Models\CmsModel;
use SierraTecnologia\Commerce\Models\OrderItem;
use SierraTecnologia\Commerce\Models\Transaction;

class Order extends CmsModel
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

    public $with = [
        'transaction'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function hasRefundedOrderItems()
    {
        if ($this->items->isNotEmpty()) {
            if ($this->items->where('was_refunded', true)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function hasActiveOrderItems()
    {
        if ($this->items->isNotEmpty()) {
            if ($this->items->where('was_refunded', false)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function remainingValue()
    {
        $refundedValue = 0;

        foreach ($this->items->where('was_refunded', true) as $item) {
            $refundedValue += $item->total;
        }

        return ($this->transaction('total') - $refundedValue);
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
