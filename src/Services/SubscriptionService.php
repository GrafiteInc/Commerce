<?php

namespace Mlantz\Hadron\Services;

use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public static function subscriptionDetails($subscription)
    {
        return view('quarx::frontend.store.subscriptions.details', ['subscription' => $subscription])->render();
    }

    public static function subscriptionDetailsBtn($subscription, $class = '')
    {
        return '<a tabindex="0" class="details '.$class.'" role="button" data-trigger="focus" data-toggle="popover" title="Subscription Details" data-content=\''. SubscriptionService::subscriptionDetails($subscription).'\'><i class="fa fa-info"></i></a>';
    }
}