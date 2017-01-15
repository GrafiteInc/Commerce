<?php

namespace Yab\Hadron\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yab\Hadron\Services\TransactionService;
use Yab\Crypto\Services\Crypto;

class TransactionController extends Controller
{
    public function __construct(TransactionService $transactionService)
    {
        $this->service = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = $this->service->paginated();

        return view('hadron::transactions.index')
            ->with('pagination', $transactions->render())
            ->with('transactions', $transactions);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $transactions = $this->service->search($request->term);

        return view('hadron::transactions.index')
            ->with('transactions', $transactions[0]->get())
            ->with('pagination', $transactions[2])
            ->with('term', $transactions[1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $transaction = $this->service->find(Crypto::decrypt($id));
        $order = $this->service->getTransactionOrder(Crypto::decrypt($id));

        return view('hadron::transactions.edit')
            ->with('order', $order)
            ->with('transaction', $transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\CreateProductRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->service->update(Crypto::decrypt($id), $request->except(['_token', '_method']));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->with('message', 'Failed to update');
    }

    /**
     * Issue a refund.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function refund(Request $request)
    {
        $result = $this->service->refund($request->uuid);

        if ($result) {
            return back()->with('message', 'Successfully refunded');
        }

        return back()->with('message', 'Failed to refund');
    }
}
