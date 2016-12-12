<?php

namespace Quarx\Modules\Hadron\Models;

use Eloquent;

class Plan extends Eloquent
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
        'stripe_name' => 'required',
        'subscription_name' => 'required',
        'descriptor' => 'required',
        'description' => 'required',
    ];

    public function getPlansByStripeId($id)
    {
        return $this->where('stripe_name', $id)->first();
    }

    public function getPriceAttribute()
    {
        return round($this->amount / 100, 2);
    }
}
