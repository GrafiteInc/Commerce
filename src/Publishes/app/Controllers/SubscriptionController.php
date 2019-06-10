<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sitec\Commerce\Services\LogisticService;
use Sitec\Commerce\Services\PlanService;
use Sitec\Crypto\Services\Crypto;

class SubscriptionController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        if (!config('commerce.subscriptions')) {
            return back()->send();
        }
        $this->service = $service;
    }

    /**
     * Subscribe to a plan
     *
     * @param  int $id
     *
     * @return Illuminate\Http\Response
     */
    public function subscribe($id)
    {
        if (is_null(auth()->user()->meta->stripe_id)) {
            return redirect('store/account/card');
        }

        $plan = $this->service->find(Crypto::decrypt($id));
        auth()->user()->meta->newSubscription($plan->subscription_name, $plan->stripe_name)->create();

        app(LogisticService::class)->afterSubscription(auth()->user(), $plan);

        return view('commerce-frontend::subscriptions.success')->with('plan', $plan);
    }

    /**
     * View all customer subscriptions
     *
     * @return Illuminate\Http\Response
     */
    public function allSubscriptions()
    {
        $subscriptions = auth()->user()->meta->subscriptions()->orderBy('created_at', 'DESC')->paginate(config('cms.pagination'));

        return view('commerce-frontend::subscriptions.all')->with('subscriptions', $subscriptions);
    }

    /**
     * Get a subscription by name
     *
     * @param  string $name
     *
     * @return Illuminate\Http\Response
     */
    public function getSubscription($name)
    {
        $subscription = auth()->user()->meta->subscription(Crypto::decrypt($name));

        return view('commerce-frontend::subscriptions.subscription')->with('subscription', $subscription);
    }

    /**
     * Cancel a subscription
     *
     * @param  Request $request
     * @param  string $name
     *
     * @return Illuminate\Http\Response
     */
    public function cancelSubscription(Request $request, $name)
    {
        auth()->user()->meta->subscriptions()
            ->where('name', Crypto::decrypt($name))
            ->where('stripe_id', Crypto::decrypt($request->stripe_id))->first()->cancel();

        app(LogisticService::class)->cancelSubscription(auth()->user(), Crypto::decrypt($name));

        return redirect('store/account/subscriptions')->with('message', 'Your subscription was cancelled');
    }
}
