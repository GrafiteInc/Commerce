<?php

namespace Sitec\Commerce\Services;

use Carbon\Carbon;
use Stripe\Coupon;
use Stripe\Plan;
use Stripe\Refund;
use Stripe\Stripe;

class StripeService
{
    public function __construct(Stripe $stripe, Plan $plan, Coupon $coupon, Refund $refund)
    {
        $this->stripe = $stripe;
        $this->plan = $plan;
        $this->coupon = $coupon;
        $this->refund = $refund;
        $this->stripe->setApiKey(config('services.stripe.secret'));
    }

    /*
     * --------------------------------------------------------------------------
     * Plans
     * --------------------------------------------------------------------------
    */

    /**
     * Collect the stripe plans.
     *
     * @return array
     */
    public function collectStripePlans()
    {
        return $this->plan->all();
    }

    /**
     * Create a plan.
     *
     * @param arr $plan
     *
     * @return bool
     */
    public function createPlan($plan)
    {
        return $this->plan->create([
            'amount' => $plan['amount'],
            'interval' => $plan['interval'],
            'name' => $plan['name'],
            'currency' => $plan['currency'],
            'statement_descriptor' => $plan['descriptor'],
            'trial_period_days' => $plan['trial_days'],
            'id' => $plan['stripe_id'],
        ]);
    }

    /**
     * Delete the plan.
     *
     * @param string $planName
     *
     * @return
     */
    public function deletePlan($planName)
    {
        $plan = $this->plan->retrieve($planName);

        return $plan->delete();
    }

    /*
     * --------------------------------------------------------------------------
     * Coupons
     * --------------------------------------------------------------------------
    */

    /**
     * Collect the stripe plans.
     *
     * @return array
     */
    public function collectStripeCoupons()
    {
        return $this->coupon->all();
    }

    /**
     * Create a coupon.
     *
     * @param arr $coupon
     *
     * @return bool
     */
    public function createCoupon($coupon)
    {
        $couponConfig = [
            'redeem_by' => Carbon::parse($coupon['end_date'])->timestamp,
            'max_redemptions' => $coupon['limit'],
            'currency' => $coupon['currency'],
            'duration' => 'once',
            'id' => $coupon['stripe_id'],
        ];

        if ($coupon['discount_type'] == 'dollar') {
            $couponConfig['amount_off'] = $coupon['amount'];
        }

        if ($coupon['discount_type'] == 'percentage') {
            $couponConfig['percent_off'] = $coupon['amount'];
        }

        return $this->coupon->create($couponConfig);
    }

    /**
     * Delete the coupon.
     *
     * @param string $couponName
     *
     * @return
     */
    public function deleteCoupon($couponName)
    {
        $coupon = $this->coupon->retrieve($couponName);

        return $coupon->delete();
    }

   /*
    * --------------------------------------------------------------------------
    * Transactions
    * --------------------------------------------------------------------------
   */

    /**
     * Refund a purchase.
     *
     * @param string $transactionId
     * @param int|null $amount
     *
     * @return obj
     */
    public function refund($transactionId, $amount)
    {
        return $this->refund->create([
            'charge' => $transactionId,
            'amount' => $amount,
        ]);
    }
}
