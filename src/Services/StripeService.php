<?php

namespace Quarx\Modules\Hadron\Services;

use Stripe\Plan;
use Stripe\Stripe;
use Stripe\Refund;
use Stripe\Customer;

class StripeService
{
    public function __construct(Stripe $stripe, Plan $plan, Customer $customer, Refund $refund)
    {
        $this->stripe = $stripe;
        $this->plan = $plan;
        $this->customer = $customer;
        $this->refund = $refund;
        $this->stripe->setApiKey(env('STRIPE_SECRET'));
    }

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

    /**
     * Refund a purchase.
     *
     * @param obj $user
     * @param obj $transaction
     *
     * @return obj
     */
    public function refund($user, $transaction)
    {
        $customer = $this->customer->retrieve($user->meta->stripe_id);

        $refund = $this->refund->create([
            'charge' => $transaction,
        ]);

        return $refund;
    }
}
