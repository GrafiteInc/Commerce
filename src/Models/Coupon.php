<?php

namespace SierraTecnologia\Commerce\Models;

use Carbon\Carbon;
use SierraTecnologia\Cms\Models\CmsModel;
use SierraTecnologia\Commerce\Services\CartService;

class Coupon extends CmsModel
{
    public $table = 'coupons';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'start_date',
        'end_date',
        'code',
        'currency',
        'discount_type',
        'for_subscriptions',
        'amount',
        'limit',
        'stripe_id',
    ];

    public static $rules = [
        'amount' => 'required',
        'limit' => 'required',
        'discount_type' => 'required',
    ];

    public function getCouponsByStripeId($id)
    {
        return $this->where('stripe_id', $id)->first();
    }

    public function expired()
    {
        $now = Carbon::now(config('app.timezone'));

        if (!is_null($this->end_date) && $now->gt(Carbon::parse($this->end_date))) {
            return true;
        }

        return false;
    }

    public function getDollarsAttribute()
    {
        return app(CartService::class)->getCurrentCouponValue($this->stripe_id);
    }

    public function getValueAttribute()
    {
        if ($this->discount_type == 'dollar') {
            return round($this->amount / 100, 2);
        }

        return $this->amount;
    }

    public function getValueStringAttribute()
    {
        if ($this->discount_type == 'dollar') {
            return '$'.$this->value;
        }

        return $this->value.'%';
    }
}
