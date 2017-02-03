<?php

namespace Yab\Quazar\Controllers;

use Yab\Quarx\Controllers\QuarxController;
use App\Services\UserService;
use Illuminate\Http\Request;
use Yab\Quazar\Services\TransactionService;

class AnalyticsController extends QuarxController
{
    public function __construct(
        TransactionService $transactionService,
        UserService $userService
    ) {
        $this->transactions = $transactionService;
        $this->users = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $transactions = $this->transactions->thisYear();

        $collected = $transactions->groupBy(function ($item) {
            return $item->created_at->format('d-M-y');
        });

        $transactionDays = collect();
        $transactionsByDay = collect();
        $balanceValues = [
            'refunds' => 0,
            'income' => 0,
        ];

        foreach ($collected as $key => $value) {
            $transactionDays->push($key);
            $transactionsByDay->push((string) round(collect($value)->sum('total'), 2));

            foreach ($value as $transaction) {
                if (!is_null($transaction->refund_date)) {
                    $balanceValues['refunds'] += $transaction->total;
                } else {
                    $balanceValues['income'] += $transaction->total;
                }
            }
        }

        return view('quazar::analytics')
            ->with('transactions', $transactions)
            ->with('balanceValues', [round($balanceValues['refunds'], 2), round($balanceValues['income'], 2)])
            ->with('transactionDays', $transactionDays)
            ->with('transactionsByDay', $transactionsByDay);
    }
}
