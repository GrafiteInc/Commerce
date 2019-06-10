<?php

namespace Sitec\Commerce\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Sitec\Commerce\Models\Plan;
use Sitec\Commerce\Services\CartService;
use Sitec\Commerce\Services\CustomerProfileService;
use Sitec\Commerce\Services\LogisticService;

class StoreHelperService
{
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function storeUrl($url)
    {
        return url(config('commerce.store_url_prefix').'/'.$url);
    }

    public function customer()
    {
        return app(CustomerProfileService::class);
    }

    public function customerSubscriptionUrl($subscription)
    {
        return $this->storeUrl('/account/subscription/'.crypto_encrypt($subscription->name));
    }

    public function subscriptionPlan($subscription)
    {
        return app(Plan::class)->getPlansByStripeId($subscription->stripe_plan);
    }

    public function subscriptionUpcoming($subscription)
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

    public function subscriptionUrl($subscription)
    {
        return $this->storeUrl('/plan/'.crypto_encrypt($subscription->id));
    }

    public function cancelSubscriptionBtn($subscription, $class = 'btn btn-danger', $buttonContent = 'Cancel Subscription')
    {
        return '<form method="post" action="'.$this->storeUrl('/account/subscription/'.crypto_encrypt($subscription->name)).'/cancel">'
        .csrf_field()
        .'<input type="hidden" name="stripe_id" value="'.crypto_encrypt($subscription->stripe_id).'">'
        .'<button class="'.$class.'">'.$buttonContent.'</button></form>';
    }

    public function moneyFormat($amount)
    {
        return number_format(round($amount, 2), 2);
    }

    public function checkoutTax()
    {
        return $this->moneyFormat($this->cartService->getCartTax());
    }

    public function checkoutTotal()
    {
        return $this->moneyFormat($this->cartService->getCartTotal());
    }

    public function checkoutSubtotal()
    {
        return $this->moneyFormat($this->cartService->getCartSubtotal());
    }

    public function couponValue()
    {
        return $this->moneyFormat($this->cartService->getCurrentCouponValue());
    }

    public function checkoutShipping()
    {
        return $this->moneyFormat(app(LogisticService::class)->shipping(auth()->user()));
    }
}
