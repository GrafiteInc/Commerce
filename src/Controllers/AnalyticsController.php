<?php

namespace Quarx\Modules\Hadron\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Quarx\Modules\Hadron\Requests\CreateProductRequest;
use Quarx\Modules\Hadron\Services\TransactionService;
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
        $transactions = $this->service->search($request->search);

        return view('hadron::transactions.index')
            ->with('term', $request->search)
            ->with('pagination', $transactions->render())
            ->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('hadron::transactions.create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\CreateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    // public function store(CreateProductRequest $request)
    // {
        // $result = $this->service->create($request->except('_token'));

        // if ($result) {
        //     return redirect('quarx/transactions/'.$result->id.'/edit')->with('message', 'Successfully created');
        // }

        // return redirect('quarx/transactions')->with('message', 'Failed to create');
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $transaction = $this->service->findTransactionsById(Crypto::decrypt($id));

        return view('hadron::transactions.edit')->with('transaction', $transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\CreateProductRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CreateProductRequest $request, $id)
    {
        // $result = $this->service->update($id, $request->except(['_token', '_method']));

        // if ($result) {
        //     return back()->with('message', 'Successfully updated');
        // }

        // return back()->with('message', 'Failed to update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect('quarx/transactions')->with('message', 'Successfully deleted');
        }

        return redirect('quarx/transactions')->with('message', 'Failed to delete');
    }
}
