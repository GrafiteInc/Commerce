<?php

namespace Yab\Quazar\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Yab\Quarx\Controllers\QuarxController;
use Yab\Quazar\Services\AnalyticsService;
use Yab\Quazar\Services\TransactionService;

class AnalyticsController extends QuarxController
{
    public function __construct(
        TransactionService $transactionService,
        AnalyticsService $analyticsService,
        UserService $userService
    ) {
        $this->transactions = $transactionService;
        $this->analyticsService = $analyticsService;
        $this->users = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $months = 1;

        if ($request->months) {
            $months = $request->months;
        }

        $transactions = $this->transactions->overMonths($months);
        $balanceValues = $this->analyticsService->balanceValues($transactions);
        $subscriptions = $this->analyticsService->getSubscriptions();
        $data = $this->analyticsService->mergeTransactionsAndSubscriptions($months);

        return view('quazar::analytics')
            ->with('transactions', $transactions)
            ->with('balanceValues', [round($balanceValues['refunds'], 2), round($balanceValues['income'], 2)])
            ->with('transactionDays', $data['days'])
            ->with('transactionsByDay', collect($data['transactions'])->values())
            ->with('subscriptionsByDay', collect($data['subscriptions'])->values())
            ->with('subscriptions', $subscriptions);
    }
}
