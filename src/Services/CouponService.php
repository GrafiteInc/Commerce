<?php

namespace Yab\Quazar\Services;

use App\Models\UserMeta;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Subscription;
use Yab\Quarx\Services\QuarxService;
use Yab\Quazar\Models\Coupon;

class CouponService
{
    public function __construct(
        Coupon $coupon,
        StripeService $stripeService,
        UserService $userService
    ) {
        $this->model = $coupon;
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
    public function collectNewCoupons()
    {
        $stripeCoupons = $this->stripeService->collectStripeCoupons()->data;

        foreach ($stripeCoupons as $coupon) {
            $localCoupon = $this->model->getCouponsByStripeId($coupon->id);

            if (!$localCoupon) {
                $endDate = null;
                $discount_type = 'percentage';

                if (!is_null($coupon->redeem_by)) {
                    $endDate = Carbon::parse($coupon->redeem_by);
                }
                if (is_null($coupon->percent_off)) {
                    $discount_type = 'dollar';
                }

                $this->model->create([
                    'stripe_id' => $coupon->id,
                    'start_date' => Carbon::createFromTimestamp($coupon->created),
                    'end_date' => $endDate,
                    'discount_type' => $discount_type,
                    'code' => $coupon->id,
                    'amount' => $coupon->amount_off,
                    'limit' => $coupon->max_redemptions ?? 1,
                    'currency' => config('quazar.currency'),
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
        return $this->model->paginate(config('quarx.pagination', 25));
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
        // $query = $this->model->orderBy('created_at', 'desc');

        // $columns = Schema::getColumnListing('plans');

        // foreach ($columns as $attribute) {
        //     $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        // }

        // return $query->paginate(config('quarx.pagination', 25));
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
        // try {
        //     $name = app(QuarxService::class)->convertToURL($payload['name']);

        //     $payload['stripe_id'] = $name;
        //     $payload['uuid'] = crypto_uuid();
        //     $payload['stripe_name'] = $name;
        //     $payload['subscription_name'] = $name;

        //     $this->stripeService->createPlan($payload);

        //     return $this->model->create($payload);
        // } catch (Exception $e) {
        //     throw new Exception('Could not generate new plan', 1);
        // }

        // return false;
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
        // return $this->model->find($id);
    }

    /**
     * Get coupons by stripe ID.
     *
     * @param int $id
     *
     * @return Plan
     */
    public function findByStripeId($id)
    {
        return $this->model->where('stripe_id', $id)->first();
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
        // try {
        //     if (!isset($payload['is_featured'])) {
        //         $payload['is_featured'] = false;
        //     } else {
        //         $payload['is_featured'] = true;
        //     }

        //     return $this->model->find($id)->update($payload);
        // } catch (Exception $e) {
        //     throw new Exception('Could not update your plan', 1);
        // }

        // return false;
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
        // try {
        //     $localPlan = $this->model->find($id);

        //     try {
        //         $planIsDeleted = $this->stripeService->deletePlan($localPlan->stripe_name);
        //     } catch (\Stripe\Error\InvalidRequest $e) {
        //         $localPlan->delete();

        //         return true;
        //     }

        //     // We need to unaubscribe our users
        //     if ($planIsDeleted) {
        //         $subscriptions = Subscription::where('stripe_plan', $localPlan->stripe_name)->get();
        //         foreach ($subscriptions as $subscription) {
        //             $user = UserMeta::find($subscription->user_meta_id);
        //             $meta->subscription($localPlan->subscription_name)->cancel();
        //         }
        //     }

        //     return $this->model->destroy($id);
        // } catch (Exception $e) {
        //     throw new Exception('Could not delete your plan', 1);
        // }

        // return false;
    }
}
