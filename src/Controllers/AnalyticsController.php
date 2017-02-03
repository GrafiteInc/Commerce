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
        $transactions = $this->transactions->thisYear();
        $balanceValues = $this->analyticsService->balanceValues($transactions);
        $transactionDays = $this->analyticsService->getTransactionsByDays($transactions);
        $subscriptions = $this->analyticsService->getSubscriptions();

        return view('quazar::analytics')
            ->with('transactions', $transactions)
            ->with('balanceValues', [round($balanceValues['refunds'], 2), round($balanceValues['income'], 2)])
            ->with('transactionDays', $transactionDays['days'])
            ->with('transactionsByDay', $transactionDays['transactions'])
            ->with('subscriptions', $subscriptions);
    }
}
