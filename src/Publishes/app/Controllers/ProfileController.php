<?php

namespace App\Http\Controllers\Quazar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Quazar\Services\CustomerProfileService;

class ProfileController extends Controller
{
    public function __construct(CustomerProfileService $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display the customer profile.
     *
     * @param int $id
     *
     * @return Response
     */
    public function customerProfile()
    {
        return view('quazar-frontend::profile.details');
    }

    /**
     * Update Customer Profile.
     *
     * @return Response
     */
    public function customerProfileUpdate(Request $request)
    {
        $this->customer->updateProfileAddress($request->except('_token'));

        return back()->with('message', 'Successfully updated');
    }

    /**
     * Add a coupon
     *
     * @return Response
     */
    public function addCoupon(Request $request)
    {
        return view('quazar-frontend::profile.coupon');
    }

    /**
     * Add coupon to profile.
     *
     * @return Response
     */
    public function submitCoupon(Request $request)
    {
        try {
            auth()->user()->meta->applyCoupon($request->coupon);
            $message = 'Successfully added coupon.';
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return back()->with('message', $message);
    }
}
