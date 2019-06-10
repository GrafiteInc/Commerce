<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SierraTecnologia\Commerce\Services\CustomerProfileService;

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
     * @return Illuminate\Http\Response
     */
    public function customerProfile()
    {
        return view('commerce-frontend::profile.details');
    }

    /**
     * Update Customer profile.
     *
     * @return Illuminate\Http\Response
     */
    public function customerProfileUpdate(Request $request)
    {
        $this->customer->updateProfileAddress($request->except('_token'));

        return back()->with('message', 'Successfully updated');
    }

    /**
     * Add a coupon form
     *
     * @return Illuminate\Http\Response
     */
    public function addCoupon(Request $request)
    {
        return view('commerce-frontend::profile.coupon');
    }

    /**
     * Add coupon to profile.
     *
     * @return Illuminate\Http\Response
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
