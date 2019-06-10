<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use Sitec\Commerce\Repositories\OrderRepository;
use Sitec\Commerce\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orders = $orderRepo;
    }

    /**
     * List all customer orders
     *
     * @return Illuminate\Http\Response
     */
    public function allOrders()
    {
        $orders = $this->orders->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(config('cms.pagination'));

        return view('commerce-frontend::orders.all')->with('orders', $orders);
    }

    /**
     * Get a customer order
     *
     * @param  int $id
     *
     * @return Illuminate\Http\Response
     */
    public function getOrder($id)
    {
        $order = $this->orders->getByCustomerAndUuid(auth()->id(), $id);

        return view('commerce-frontend::orders.order')->with('order', $order);
    }

    /**
     * Cancel a customer order
     *
     * @param  int $id
     *
     * @return Illuminate\Http\Response
     */
    public function cancelOrder($id)
    {
        if (app(OrderService::class)->cancelOrder(auth()->id(), $id)) {
            return back()->with('message', 'Order cancelled');
        }

        return back();
    }
}
