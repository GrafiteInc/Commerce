<?php

namespace Yab\Quazar\Controllers\App;

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
     * Display the store homepage.
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
}
