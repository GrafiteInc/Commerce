<?php

namespace app\Http\Controllers\Hadron;

use App\Http\Controllers\Controller;
use Auth;
use Yab\Hadron\Repositories\SubscriptionRepository;
use Yab\Hadron\Services\PlanService;
use Yab\Crypto\Services\Crypto;

class SubscriptionController extends Controller
{
    protected $service;

    public function __construct(SubscriptionRepository $subscriptionRepo, PlanService $service)
    {
        $this->subscriptions = $subscriptionRepo;
        $this->service = $service;
    }

    public function subscribe($id)
    {
        if (is_null(auth()->user()->meta->stripe_id)) {
            return redirect('store/account/card');
        }

        $plan = $this->service->find(Crypto::decrypt($id));
        auth()->user()->meta->newSubscription($plan->subscription_name, $plan->stripe_name)->create();

        return view('hadron-frontend::subscriptions.success')->with('plan', $plan);
    }

    public function allSubscriptions()
    {
        $subscriptions = auth()->user()->meta->subscriptions()->orderBy('created_at', 'DESC')->paginate(env('PAGINATION'));

        return view('hadron-frontend::subscriptions.all')->with('subscriptions', $subscriptions);
    }

    public function getSubscription($name)
    {
        $subscription = auth()->user()->meta->subscription($name);

        return view('hadron-frontend::subscriptions.subscription')->with('subscription', $subscription);
    }

    public function cancelSubscription($id)
    {
    }

    public function pauseSubscription($id)
    {
    }
}
