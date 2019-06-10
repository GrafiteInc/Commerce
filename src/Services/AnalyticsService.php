<?php

namespace Sitec\Commerce\Services;

use Carbon\Carbon;
use Laravel\Cashier\Subscription;
use Sitec\Commerce\Models\Transaction;

class AnalyticsService
{
    public function balanceValues($transactions)
    {
        $collected = $transactions->groupBy(function ($item) {
            return $item->created_at->format('d-M-y');
        });

        $balanceValues = [
            'refunds' => 0,
            'income' => 0,
        ];

        foreach ($collected as $key => $value) {
            foreach ($value as $transaction) {
                if ($transaction->refunds->count() > 0) {
                    $balanceValues['refunds'] += $transaction->refunds->sum('amount');
                } else {
                    $balanceValues['income'] += $transaction->total;
                }
            }
        }

        return $balanceValues;
    }

    public function getTransactionsByDays($transactions)
    {
        $collected = $transactions->groupBy(function ($item) {
            return $item->created_at->format('d-M-y');
        });

        $transactionDays = collect();
        $transactionsByDay = collect();

        foreach ($collected as $key => $value) {
            $transactionDays->push($key);
            $transactionsByDay->push((string) round(collect($value)->sum('total'), 2));
        }

        return [
            'days' => $transactionDays,
            'transactions' => $transactionsByDay,
        ];
    }

    public function getSubscriptions()
    {
        return Subscription::all();
    }

    public function mergeTransactionsAndSubscriptions($months)
    {
        $daysCollection = [];
        $transactionsCollection = [];
        $subscriptionsCollection = [];
        $monthsAgo = Carbon::now()->subMonths($months);
        $now = Carbon::now();

        foreach (range(1, $monthsAgo->diffInDays($now)) as $day) {
            $date = Carbon::now()->subMonths($months)->addDays($day);
            $daysColleciton[] = $date->format('d-M-y');
            $transactionsCollection[$date->format('d-M-y')] = Transaction::where('created_at', 'like', $date->format('Y-m-d').'%')->pluck('total')->sum();
            $subscriptionsSumByDay = $this->getSubscriptionSum($date);
            $subscriptionCollection[$date->format('d-M-y')] = $subscriptionsSumByDay;
        }

        return [
            'days' => $daysColleciton,
            'transactions' => $transactionsCollection,
            'subscriptions' => $subscriptionCollection,
        ];
    }

    public function getSubscriptionSum($date)
    {
        $day = Carbon::parse($date)->format('Y-m-d');
        $subscriptionSoldOnDay = Subscription::where('created_at', 'like', $day.'%')->get();
        $subscriptionsSold = 0;

        foreach ($subscriptionSoldOnDay as $subscription) {
            $plan = app(PlanService::class)->getPlansByStripeId($subscription->stripe_plan);
            $subscriptionsSold += $plan->price;
        }

        return $subscriptionsSold;
    }

    public function getSubscriptionsOverMonths($months)
    {
        $monthsAgo = Carbon::now()->subMonths($months);
        $now = Carbon::now();

        $subscriptions = Subscription::where('created_at', '>=', $monthsAgo)->where('created_at', '<=', $now)->get();

        return $subscriptions;
    }
}
