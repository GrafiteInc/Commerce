<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SierraTecnologia\Cashier\Billable;

class UserMeta extends Model
{
    use Billable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'phone',
        'marketing',
        'terms_and_cond',
        'is_active',
        'activation_token',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'shipping_address',
        'billing_address',
    ];

    /**
     * User.
     *
     * @return Relationship
     */
    public function user()
    {
        return User::where('id', $this->user_id)->first();
    }
}
