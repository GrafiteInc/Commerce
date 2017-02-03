<?php

namespace Yab\Quazar\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Yab\Quazar\Models\Plan;
use Yab\Quazar\Services\CartService;
use Yab\Quazar\Services\CustomerProfileService;
use Yab\Quazar\Services\LogisticService;

class StoreHelper
{
    public static function storeUrl($url)
    {
        return url('store/'.$url);
    }

    public static function customer()
    {
        return app(CustomerProfileService::class);
    }

    /*
     * --------------------------------------------------------------------------
     * Subscriptions
     * --------------------------------------------------------------------------
    */

    public static function customerSubscriptionUrl($subscription)
    {
        return url('store/account/subscriptions/'.crypto_encrypt($subscription->name));
    }

    public static function subscriptionPlan($subscription)
    {
        return app(Plan::class)->getPlansByStripeId($subscription->stripe_plan);
    }

    public static function subscriptionUpcoming($subscription)
    {
        $key = $subscription->stripe_id.'__'.auth()->id();

        if (!Cache::has($key)) {
            $invoice = auth()->user()->meta->upcomingInvoice($subscription->name);
            Cache::put($key, [
                'total' => round(($invoice->total / 100), 2),
                'attempt_count' => $invoice->attempt_count,
                'period_start' => $invoice->period_start,
                'period_end' => $invoice->period_end,
                'date' => Carbon::createFromTimestamp($invoice->date),
            ], 25);
        }

        return Cache::get($key);
    }

    public static function subscriptionUrl($subscription)
    {
        return url('store/plan/'.crypto_encrypt($subscription->id));
    }

    public static function cancelSubscriptionBtn($subscription, $class = 'btn btn-danger')
    {
        return '<form method="post" action="'.url('store/account/subscriptions/'.crypto_encrypt($subscription->name)).'/cancel">'
        .csrf_field()
        .'<input type="hidden" name="stripe_id" value="'.crypto_encrypt($subscription->stripe_id).'">'
        .'<button class="'.$class.'">Cancel Subscription</button></form>';
    }

    /*
     * --------------------------------------------------------------------------
     * Checkout
     * --------------------------------------------------------------------------
    */

    public static function checkoutTax()
    {
        return app(CartService::class)->getCartTax();
    }

    public static function checkoutTotal()
    {
        return app(CartService::class)->getCartTotal();
    }

    public static function checkoutSubtotal()
    {
        return app(CartService::class)->getCartSubtotal();
    }

    public static function checkoutShipping()
    {
        return app(LogisticService::class)->shipping(auth()->user());
    }
}
