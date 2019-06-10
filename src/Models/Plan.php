<?php

namespace SierraTecnologia\Commerce\Models;

use SierraTecnologia\Cms\Models\CmsModel;

class Plan extends CmsModel
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

    public function getAmountAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getHrefAttribute()
    {
        return route('commerce.plan', [$this->uuid]);
    }

    public function subscribeBtn($content = '', $class = '')
    {
        return '<form method="post" action="'.route('commerce.subscribe', [crypto_encrypt($this->id)]).'">'.csrf_field().'<button class="'.$class.'">'.$content.'</button></form>';
    }
}
