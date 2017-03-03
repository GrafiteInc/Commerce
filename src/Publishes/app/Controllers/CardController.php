<?php

namespace App\Http\Controllers\Quazar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Quazar\Services\CustomerProfileService;

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
     * @return Response
     */
    public function getCard()
    {
        if (is_null(auth()->user()->meta->stripe_id)) {
            return view('quazar-frontend::profile.card.set');
        }

        return view('quazar-frontend::profile.card.get');
    }

    /**
     * Display the change card.
     *
     * @return Response
     */
    public function changeCard()
    {
        return view('quazar-frontend::profile.card.change');
    }

    /**
     * Set a credit card.
     *
     * @param Request $request
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
