<?php

namespace App\Http\Controllers\Hadron;

use Auth;
use Quarx;
use Request;
use Redirect;
use App\Http\Controllers\Controller;
use Yab\Hadron\Repositories\SubscriptionRepository;

class SubscriptionController extends Controller
{

    function __construct(SubscriptionRepository $subscriptionRepo)
    {
        $this->subscriptions = $subscriptionRepo;
    }

    public function allSubscriptions()
    {
        $subscriptions = $this->subscriptions->getByCustomer(Auth::id())->orderBy('created_at', 'DESC')->paginate(env('PAGINATION'));
        return view('hadron-frontend::subscriptions.all')->with('subscriptions', $subscriptions);
    }

    public function getSubscription($id)
    {
        $subscription = $this->subscriptions->getByCustomerAndId(Auth::id(), $id);
        return view('hadron-frontend::subscriptions.subscription')->with('subscription', $subscription);
    }

    public function cancelSubscription($id)
    {

    }

    public function pauseSubscription($id)
    {

    }

}
