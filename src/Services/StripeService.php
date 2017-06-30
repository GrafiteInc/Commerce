<?php

namespace Yab\Quazar\Services;

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
        return $this->coupon->create([
            'amount' => $coupon['amount'],
            'interval' => $coupon['interval'],
            'name' => $coupon['name'],
            'currency' => $coupon['currency'],
            'statement_descriptor' => $coupon['descriptor'],
            'trial_period_days' => $coupon['trial_days'],
            'id' => $coupon['stripe_id'],
        ]);
    }

    /**
     * Delete the plan.
     *
     * @param string $planName
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
     * @param obj $user
     * @param obj $transaction
     *
     * @return obj
     */
    public function refund($transaction)
    {
        return $this->refund->create([
            'charge' => $transaction,
        ]);
    }
}
