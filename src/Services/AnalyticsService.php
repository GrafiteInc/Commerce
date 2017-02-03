<?php

namespace Yab\Quazar\Services;

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
                if (!is_null($transaction->refund_date)) {
                    $balanceValues['refunds'] += $transaction->total;
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
        // for each plan, get the subscribers
        // show a chart of subscriptions
        // current monthly income
        // list of subscribers
        // pie graph of subscribed vs cancelled
    }
}
