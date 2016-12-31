<?php

namespace Quarx\Modules\Hadron\Services;

use App\Models\UserMeta;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Subscription;
use Quarx\Modules\Hadron\Models\Plan;
use Yab\Quarx\Services\QuarxService;

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

    public function create($payload)
    {
        try {
            $name = app(QuarxService::class)->convertToURL($payload['name']);

            $payload['stripe_id'] = $name;
            $payload['stripe_name'] = $name;
            $payload['subscription_name'] = $name;

            $this->stripeService->createPlan($payload);

            return $this->plan->create($payload);
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

    /**
     * Get subscribers.
     *
     * @param Quarx\Modules\Hadron\Models\Plan $plan
     *
     * @return Illuminate\Support\Collection
     */
    public function getSubscribers($plan)
    {
        $userCollection = collect();
        $subscriptions = Subscription::where('stripe_plan', $plan->stripe_name)->get();

        foreach ($subscriptions as $subscription) {
            $userCollection->push(UserMeta::find($subscription->user_meta_id));
        }

        return $userCollection;
    }

    public function cancelSubscription($planId, $userMetaId)
    {
        $plan = $this->find($planId);
        $userMeta = UserMeta::find($userMetaId);

        return $userMeta->subscription($plan->subscription_name)->cancel();
    }

    public function destroy($id)
    {
        try {
            $localPlan = $this->plan->find($id);

            try {
                $planIsDeleted = $this->stripeService->deletePlan($localPlan->stripe_name);
            } catch (\Stripe\Error\InvalidRequest $e) {
                $localPlan->delete();

                return true;
            }

            // We need to unaubscribe our users
            if ($planIsDeleted) {
                $subscriptions = Subscription::where('stripe_plan', $localPlan->stripe_name)->get();
                foreach ($subscriptions as $subscription) {
                    $user = UserMeta::find($subscription->user_meta_id);
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
