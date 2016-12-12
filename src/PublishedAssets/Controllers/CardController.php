<?php

namespace app\Http\Controllers\Hadron;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Quarx\Modules\Hadron\Services\CustomerProfileService;

class CardController extends Controller
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
    public function getCard()
    {
        if (is_null(auth()->user()->meta->stripe_id)) {
            return view('hadron-frontend::profile.card.set');
        }

        return view('hadron-frontend::profile.card.get');
    }

    /**
     * Display the store homepage.
     *
     * @return Response
     */
    public function changeCard()
    {
        return view('hadron-frontend::profile.card.change');
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
