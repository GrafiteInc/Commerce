<?php

namespace Grafite\Commerce\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Grafite\Commerce\Models\Plan;
use Grafite\Commerce\Services\CartService;
use Grafite\Commerce\Services\CustomerProfileService;
use Grafite\Commerce\Services\LogisticService;

class StoreHelper
{
    public static function storeUrl($url)
    {
        return url(config('commerce.store_url_prefix').'/'.$url);
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
        return url(config('commerce.store_url_prefix').'/account/subscription/'.crypto_encrypt($subscription->name));
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
        return url(config('commerce.store_url_prefix').'/plan/'.crypto_encrypt($subscription->id));
    }

    public static function cancelSubscriptionBtn($subscription, $class = 'btn btn-danger')
    {
        return '<form method="post" action="'.url(config('commerce.store_url_prefix').'/account/subscription/'.crypto_encrypt($subscription->name)).'/cancel">'
        .csrf_field()
        .'<input type="hidden" name="stripe_id" value="'.crypto_encrypt($subscription->stripe_id).'">'
        .'<button class="'.$class.'">Cancel Subscription</button></form>';
    }

    /*
     * --------------------------------------------------------------------------
     * Checkout
     * --------------------------------------------------------------------------
    */

    public static function moneyFormat($amount)
    {
        return number_format(round($amount, 2), 2);
    }

    public static function checkoutTax()
    {
        return StoreHelper::moneyFormat(app(CartService::class)->getCartTax());
    }

    public static function checkoutTotal()
    {
        return StoreHelper::moneyFormat(app(CartService::class)->getCartTotal());
    }

    public static function checkoutSubtotal()
    {
        return StoreHelper::moneyFormat(app(CartService::class)->getCartSubtotal());
    }

    public static function couponValue()
    {
        return StoreHelper::moneyFormat(app(CartService::class)->getCurrentCouponValue());
    }

    public static function checkoutShipping()
    {
        return StoreHelper::moneyFormat(app(LogisticService::class)->shipping(auth()->user()));
    }
}
