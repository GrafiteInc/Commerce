<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sitec\Commerce\Services\CustomerProfileService;

class CardController extends Controller
{
    public function __construct(CustomerProfileService $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display the get card.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function getCard()
    {
        if (is_null(auth()->user()->meta->stripe_id)) {
            return view('commerce-frontend::profile.card.set');
        }

        return view('commerce-frontend::profile.card.get');
    }

    /**
     * Display the change card.
     *
     * @return Illuminate\Http\Response
     */
    public function changeCard()
    {
        return view('commerce-frontend::profile.card.change');
    }

    /**
     * Set a credit card.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function setCard(Request $request)
    {
        $user = auth()->user();

        if (is_null($user->meta->stripe_id) && $request->input('stripeToken')) {
            $user->meta->createAsStripeCustomer($request->input('stripeToken'));
        } elseif ($request->input('stripeToken')) {
            $user->meta->updateCard($request->input('stripeToken'));
        }

        return redirect('store/account/card')->with('message', 'Successfully set your credit card');
    }
}
