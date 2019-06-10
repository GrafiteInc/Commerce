<?php

namespace Sitec\Commerce\Http\Controllers;

use Sitec\Cms\Controllers\SitecCmsController;
use Sitec\Commerce\Services\OrderItemService;
use Sitec\Commerce\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends SitecCmsController
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

        return view('commerce::orders.index')
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

        return view('commerce::orders.index')
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
        $order = $this->service->find($id);

        return view('commerce::orders.edit')->with('order', $order);
    }

    /**
     * Show order item
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function item($id, Request $request)
    {
        $orderItem = app(OrderItemService::class)->find($id);

        return view('commerce::orders.item')->with('orderItem', $orderItem);
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
        $result = $this->service->update($id, $request->except(['_token', '_method']));

        if ($result) {
            return back()->with('success', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Cancel an order item
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function cancelItem(Request $request)
    {
        $result = app(OrderItemService::class)->cancel($request->id);

        if ($result) {
            return back()->with('success', 'Successfully cancelled');
        }

        return back()->with('error', 'Failed to cancel');
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
        $result = $this->service->cancel($request->id);

        if ($result) {
            return redirect(config('cms.backend-route-prefix', 'cms').'/orders')->with('success', 'Successfully cancelled');
        }

        return redirect(config('cms.backend-route-prefix', 'cms').'/orders')->with('error', 'Failed to cancel');
    }
}
