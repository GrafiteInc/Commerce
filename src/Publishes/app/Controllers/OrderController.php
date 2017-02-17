<?php

namespace App\Http\Controllers\Quazar;

use App\Http\Controllers\Controller;
use Yab\Quazar\Repositories\OrderRepository;
use Yab\Quazar\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orders = $orderRepo;
    }

    public function allOrders()
    {
        $orders = $this->orders->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(config('quarx.pagination'));

        return view('quazar-frontend::orders.all')->with('orders', $orders);
    }

    public function getOrder($id)
    {
        $order = $this->orders->getByCustomerAndUuid(auth()->id(), $id);

        return view('quazar-frontend::orders.order')->with('order', $order);
    }

    public function cancelOrder($id)
    {
        if (app(OrderService::class)->cancelOrder(auth()->id(), $id)) {
            return back()->with('message', 'Order cancelled');
        }

        return back();
    }
}
