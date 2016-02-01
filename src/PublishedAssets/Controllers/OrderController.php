<?php

namespace App\Http\Controllers\Hadron;

use Auth;
use Quarx;
use Request;
use Redirect;
use App\Http\Controllers\Controller;
use Yab\Hadron\Repositories\OrderRepository;

class OrderController extends Controller
{

    function __construct(OrderRepository $transactionRepo)
    {
        $this->orders = $transactionRepo;
    }

    public function allOrders()
    {
        $orders = $this->orders->getByCustomer(Auth::id())->orderBy('created_at', 'DESC')->paginate(env('PAGINATION'));
        return view('hadron-frontend::orders.all')->with('orders', $orders);
    }

    public function getOrder($id)
    {
        $order = $this->orders->getByCustomerAndId(Auth::id(), $id);
        return view('hadron-frontend::orders.order')->with('order', $order);
    }

    public function cancelOrder($id)
    {

    }

}
