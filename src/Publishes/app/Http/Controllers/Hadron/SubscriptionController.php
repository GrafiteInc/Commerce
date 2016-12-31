<?php

namespace App\Http\Controllers\Hadron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Quarx\Modules\Hadron\Services\LogisticService;
use Quarx\Modules\Hadron\Services\PlanService;
use Yab\Crypto\Services\Crypto;

class SubscriptionController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        $this->service = $service;
    }

    public function subscribe($id)
    {
        if (is_null(auth()->user()->meta->stripe_id)) {
            return redirect('store/account/card');
        }

        $plan = $this->service->find(Crypto::decrypt($id));
        auth()->user()->meta->newSubscription($plan->subscription_name, $plan->stripe_name)->create();

        app(LogisticService::class)->afterSubscription(auth()->user(), $plan);

        return view('hadron-frontend::subscriptions.success')->with('plan', $plan);
    }

    public function allSubscriptions()
    {
        $subscriptions = auth()->user()->meta->subscriptions()->orderBy('created_at', 'DESC')->paginate(env('PAGINATION'));

        return view('hadron-frontend::subscriptions.all')->with('subscriptions', $subscriptions);
    }

    public function getSubscription($name)
    {
        $subscription = auth()->user()->meta->subscription(Crypto::decrypt($name));

        return view('hadron-frontend::subscriptions.subscription')->with('subscription', $subscription);
    }

    public function cancelSubscription(Request $request, $name)
    {
        auth()->user()->meta->subscriptions()
            ->where('name', Crypto::decrypt($name))
            ->where('stripe_id', Crypto::decrypt($request->stripe_id))->first()->cancel();

        app(LogisticService::class)->cancelSubscription(auth()->user(), Crypto::decrypt($name));

        return redirect('store/account/subscriptions')->with('message', 'Your subscription was cancelled');
    }
}
