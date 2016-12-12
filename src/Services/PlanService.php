<?php

namespace Quarx\Modules\Hadron\Services;

use App\Services\UserService;
use Illuminate\Support\Facades\Schema;
use Quarx\Modules\Hadron\Models\Plan;

class PlanService
{
    public function __construct(
        Plan $plan,
        StripeService $stripeService,
        UserService $userService
    ) {
        $this->plan = $plan;
        $this->stripeService = $stripeService;
        $this->userService = $userService;
    }

    public function all()
    {
        return $this->plan->all();
    }

    public function allEnabled()
    {
        return $this->plan->where('enabled', true)->get();
    }

    public function collectNewPlans()
    {
        $stripePlans = $this->stripeService->collectStripePlans()->data;
        foreach ($stripePlans as $plan) {
            $localPlan = $this->plan->getPlansByStripeId($plan->id);

            if (!$localPlan) {
                $this->plan->create([
                    'name' => $plan->id,
                    'amount' => $plan->amount,
                    'interval' => $plan->interval,
                    'currency' => $plan->currency,
                    'stripe_name' => $plan->id,
                    'subscription_name' => $plan->id,
                    'descriptor' => $plan->statement_descriptor,
                    'description' => $plan->statement_descriptor,
                ]);
            }
        }
    }

    public function paginated()
    {
        return $this->plan->paginate(env('paginate', 25));
    }

    public function search($input)
    {
        $query = $this->plan->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('plans');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input.'%');
        }

        return $query->paginate(env('paginate', 25));
    }

    public function create($input)
    {
        try {
            $input['stripe_id'] = $input['stripe_name'];
            $this->stripeService->createPlan($input);

            return $this->plan->create($input);
        } catch (Exception $e) {
            throw new Exception('Could not generate new plan', 1);
        }

        return false;
    }

    public function find($id)
    {
        return $this->plan->find($id);
    }

    public function getPlansByStripeId($id)
    {
        return $this->plan->getPlansByStripeId($id);
    }

    public function update($id, $payload)
    {
        try {
            return $this->plan->find($id)->update($payload);
        } catch (Exception $e) {
            throw new Exception('Could not update your plan', 1);
        }

        return false;
    }

    public function stateChange($id, $state)
    {
        $payload = [
            'enabled' => true,
        ];

        if ($state == 'disable') {
            $payload['enabled'] = false;
        }

        return $this->plan->find($id)->update($payload);
    }

    public function destroy($id)
    {
        try {
            $localPlan = $this->plan->find($id);
            $planIsDeleted = $this->stripeService->deletePlan($localPlan->stripe_name);

            // We need to unaubscribe our users
            if ($planIsDeleted) {
                $subscriptions = Subscription::where('stripe_plan', $localPlan->stripe_name)->get();
                foreach ($subscriptions as $subscription) {
                    $meta = $this->userService->findByMetaID($subscription->user_meta_id);
                    $meta->subscription($localPlan->subscription_name)->cancel();
                }
            }

            return $this->plan->destroy($id);
        } catch (Exception $e) {
            throw new Exception('Could not delete your plan', 1);
        }

        return false;
    }
}
