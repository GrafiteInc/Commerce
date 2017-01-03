<?php

namespace Quarx\Modules\Hadron\Models;

use Yab\Quarx\Models\QuarxModel;

class Plan extends QuarxModel
{
    public $table = 'plans';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'name',
        'title',
        'amount',
        'interval',
        'currency',
        'enabled',
        'stripe_name',
        'trial_days',
        'subscription_name',
        'descriptor',
        'description',
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

    public function getPriceAttribute()
    {
        return round($this->amount / 100, 2);
    }
}
