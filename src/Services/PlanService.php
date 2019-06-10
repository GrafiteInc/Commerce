<?php

namespace Sitec\Commerce\Services;

use App\Models\UserMeta;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Subscription;
use Sitec\Commerce\Models\Plan;
use Sitec\Cms\Services\CmsService;

class PlanService
{
    public function __construct(
        Plan $plan,
        StripeService $stripeService,
        UserService $userService
    ) {
        $this->model = $plan;
        $this->stripeService = $stripeService;
        $this->userService = $userService;
    }

    /**
     * Get all Plans.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get all enabled plans.
     *
     * @return Collection
     */
    public function allEnabled()
    {
        return $this->model->where('enabled', true)->get();
    }

    /**
     * Collect the new plans.
     */
    public function collectNewPlans()
    {
        $stripePlans = $this->stripeService->collectStripePlans()->data;
        foreach ($stripePlans as $plan) {
            $localPlan = $this->model->getPlansByStripeId($plan->id);

            if (!$localPlan) {
                $this->model->create([
                    'uuid' => crypto_uuid(),
                    'name' => $plan->id,
                    'price' => $plan->amount,
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

    /**
     * Get paginated plans.
     *
     * @return Collection
     */
    public function paginated()
    {
        return $this->model->paginate(config('cms.pagination', 25));
    }

    /**
     * Search all the plans.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('plans');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return $query->paginate(config('cms.pagination', 25));
    }

    /**
     * Create a plan.
     *
     * @param array $payload
     *
     * @return Plan
     */
    public function create($payload)
    {
        try {
            $name = app(CmsService::class)->convertToURL($payload['name']);

            $payload['stripe_id'] = $name;
            $payload['uuid'] = crypto_uuid();
            $payload['stripe_name'] = $name;
            $payload['subscription_name'] = $name;

            $this->stripeService->createPlan($payload);

            return $this->model->create($payload);
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new Exception('Could not generate new plan', 1);
        }

        return false;
    }

    /**
     * Find a plan.
     *
     * @param int $id
     *
     * @return Plan
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find a plan by uuid.
     *
     * @param string $uuid
     *
     * @return Plan
     */
    public function findByUuid($uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    /**
     * Get plans by stripe ID.
     *
     * @param int $id
     *
     * @return Plan
     */
    public function getPlansByStripeId($id)
    {
        return $this->model->getPlansByStripeId($id);
    }

    /**
     * Update a plan.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return mixed
     */
    public function update($id, $payload)
    {
        try {
            if (!isset($payload['is_featured'])) {
                $payload['is_featured'] = false;
            } else {
                $payload['is_featured'] = true;
            }

            return $this->model->find($id)->update($payload);
        } catch (Exception $e) {
            throw new Exception('Could not update your plan', 1);
        }

        return false;
    }

    /**
     * Change the state of a plan.
     *
     * @param int  $id
     * @param bool $state
     *
     * @return bool
     */
    public function stateChange($id, $state)
    {
        $payload = [
            'enabled' => true,
        ];

        if ($state == 'disable') {
            $payload['enabled'] = false;
        }

        return $this->model->find($id)->update($payload);
    }

    /**
     * Get subscribers.
     *
     * @param Sitec\Commerce\Models\Plan $plan
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

    /**
     * Cancel a subscription.
     *
     * @param int $planId
     * @param int $userMetaId
     *
     * @return bool
     */
    public function cancelSubscription($planId, $userMetaId)
    {
        $plan = $this->find($planId);
        $userMeta = UserMeta::find($userMetaId);

        return $userMeta->subscription($plan->subscription_name)->cancel();
    }

    /**
     * Destroy a plan.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $localPlan = $this->model->find($id);

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

            return $this->model->destroy($id);
        } catch (Exception $e) {
            throw new Exception('Could not delete your plan', 1);
        }

        return false;
    }
}
