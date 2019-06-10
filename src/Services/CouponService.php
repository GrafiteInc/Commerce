<?php

namespace Sitec\Commerce\Services;

use App\Models\UserMeta;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Subscription;
use Sitec\Cms\Services\CmsService;
use Sitec\Commerce\Models\Coupon;

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
     * Get all Coupons.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get all enabled coupons.
     *
     * @return Collection
     */
    public function allEnabled()
    {
        return $this->model->where('enabled', true)->get();
    }

    /**
     * Collect the new coupons.
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
                    'currency' => config('commerce.currency'),
                    'for_subscriptions' => true,
                ]);
            }
        }
    }

    /**
     * Get paginated coupons.
     *
     * @return Collection
     */
    public function paginated()
    {
        return $this->model->paginate(config('cms.pagination', 25));
    }

    /**
     * Search all the coupons.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('coupons');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return $query->paginate(config('cms.pagination', 25));
    }

    /**
     * Create a coupon.
     *
     * @param array $payload
     *
     * @return Coupon
     */
    public function create($payload)
    {
        try {
            $payload['stripe_id'] = $payload['code'];
            $payload['currency'] = config('commerce.currency');

            if (empty($payload['start_date'])) {
                $payload['start_date'] = Carbon::now();
            }

            if (empty($payload['end_date'])) {
                $payload['end_date'] = Carbon::now()->addDays(30);
            }

            if (isset($payload['for_subscriptions'])) {
                $payload['for_subscriptions'] = true;
            } else {
                $payload['for_subscriptions'] = false;
            }

            if ($payload['for_subscriptions']) {
                $this->stripeService->createCoupon($payload);
            }

            return $this->model->create($payload);
        } catch (Exception $e) {
            throw new Exception('Could not generate new coupon', 1);
        }

        return false;
    }

    /**
     * Find a coupon.
     *
     * @param int $id
     *
     * @return Coupon
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get coupons by stripe ID.
     *
     * @param int $id
     *
     * @return Coupon
     */
    public function findByStripeId($id)
    {
        return $this->model->where('stripe_id', $id)->first();
    }

    /**
     * Destroy a coupon.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $localCoupon = $this->model->find($id);

            try {
                $couponIsDeleted = $this->stripeService->deleteCoupon($localCoupon->stripe_id);
            } catch (\Stripe\Error\InvalidRequest $e) {
                $localCoupon->delete();

                return true;
            }

            return $this->model->destroy($id);
        } catch (Exception $e) {
            throw new Exception('Could not delete your coupon', 1);
        }

        return false;
    }
}
