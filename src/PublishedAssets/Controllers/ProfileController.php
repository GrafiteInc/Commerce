<?php

namespace App\Http\Controllers\Hadron;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Hadron\Services\CustomerProfileService;

class ProfileController extends Controller
{

    function __construct(CustomerProfileService $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display the store homepage
     *
     * @param  int $id
     *
     * @return Response
     */
    public function customerProfile()
    {
        return view('hadron-frontend::profile.details');
    }

    /**
     * Update Customer Profile
     *
     * @return Response
     */
    public function customerProfileUpdate(Request $request)
    {
        $profile = $this->customer->findByUserId(Auth::id());
        $this->customer->updateProfileAddress($profile->id, $request->except('_token'));
        return back()->with('message', 'Successfully updated');
    }

}
