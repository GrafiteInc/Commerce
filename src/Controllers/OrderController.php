<?php

namespace Yab\Quazar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yab\Quazar\Services\OrderService;
use Yab\Crypto\Services\Crypto;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->service = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $this->service->paginated();

        return view('quazar::orders.index')
            ->with('pagination', $orders->render())
            ->with('orders', $orders);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $orders = $this->service->search($request->term);

        return view('quazar::orders.index')
            ->with('orders', $orders[0]->get())
            ->with('pagination', $orders[2])
            ->with('term', $orders[1]);
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
        $order = $this->service->findOrdersById(Crypto::decrypt($id));

        return view('quazar::orders.edit')->with('order', $order);
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $result = $this->service->cancelOrder($request->id);

        if ($result) {
            return redirect('quarx/orders')->with('message', 'Successfully cancelled');
        }

        return redirect('quarx/orders')->with('message', 'Failed to cancel');
    }
}
