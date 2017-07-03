<?php

namespace Yab\Quazar\Models;

use Carbon\Carbon;
use Yab\Quarx\Models\QuarxModel;

class Coupon extends QuarxModel
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
        'amount',
        'limit',
        'stripe_id',
    ];

    public static $rules = [
        // 'name' => 'required',
        // 'amount' => 'required',
        // 'interval' => 'required',
        // 'currency' => 'required',
        // 'descriptor' => 'required',
        // 'description' => 'required',
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

    // public function getFrequencyAttribute()
    // {
    //     switch ($this->interval) {
    //         case 'week':
    //             return 'weekly';
    //         case 'month':
    //             return 'monthly';
    //         case 'year':
    //             return 'yearly';
    //         default:
    //             return $this->interval;
    //     }
    // }

    // public function getPriceAttribute()
    // {
    //     return round($this->amount / 100, 2);
    // }

    // public function getHrefAttribute()
    // {
    //     return route('quazar.plan', [$this->uuid]);
    // }

    // public function subscribeBtn($content = '', $class = '')
    // {
    //     return '<form method="post" action="'.route('quazar.subscribe', [crypto_encrypt($this->id)]).'">'.csrf_field().'<button class="'.$class.'">'.$content.'</button></form>';
    // }
}
