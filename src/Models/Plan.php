<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;

class Plan extends QuarxModel
{
    public $table = 'plans';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'name',
        'title',
        'uuid',
        'amount',
        'interval',
        'currency',
        'enabled',
        'stripe_name',
        'trial_days',
        'subscription_name',
        'descriptor',
        'description',
        'is_featured',
    ];

    public static $rules = [
        'name' => 'required',
        'amount' => 'required',
        'interval' => 'required',
        'currency' => 'required',
        'descriptor' => 'required',
        'description' => 'required',
    ];

    public function getPlansByStripeId($name)
    {
        return $this->where('stripe_name', $name)->first();
    }

    public function getFrequencyAttribute()
    {
        switch ($this->interval) {
            case 'week':
                return 'weekly';
            case 'month':
                return 'monthly';
            case 'year':
                return 'yearly';
            default:
                return $this->interval;
        }
    }

    public function getPriceAttribute()
    {
        return round($this->amount / 100, 2);
    }

    public function getHrefAttribute()
    {
        return url('store/plan/'.$this->uuid);
    }

    public function subscribeBtn($content = '', $class = '')
    {
        return '<form method="post" action="'.url('store/subscribe/'.crypto_encrypt($this->id)).'">'.csrf_field().'<button class="'.$class.'">'.$content.'</button></form>';
    }
}
