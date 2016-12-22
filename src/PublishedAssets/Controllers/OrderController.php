<?php

namespace App\Http\Controllers\Hadron;

use App\Http\Controllers\Controller;
use Quarx\Modules\Hadron\Repositories\OrderRepository;
use Yab\Crypto\Services\Crypto;

class OrderController extends Controller
{
    public function __construct(OrderRepository $transactionRepo)
    {
        $this->orders = $transactionRepo;
    }

    public function allOrders()
    {
        $orders = $this->orders->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(env('PAGINATION'));

        return view('hadron-frontend::orders.all')->with('orders', $orders);
    }

    public function getOrder($id)
    {
        $id = Crypto::decrypt($id);
        $order = $this->orders->getByCustomerAndId(auth()->id(), $id);

        return view('hadron-frontend::orders.order')->with('order', $order);
    }

    public function cancelOrder($id)
    {
    }
}
