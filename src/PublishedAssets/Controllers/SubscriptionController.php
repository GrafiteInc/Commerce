<?php

namespace App\Http\Controllers\Hadron;

use Quarx;
use Request;
use Redirect;
use App\Http\Controllers\Controller;
use Yab\Hadron\Services\CartService;
use Yab\Hadron\Services\QuarxResponseService;

class CheckoutController extends Controller
{
    private $cartService;

    function __construct(CartService $cartService)
    {
        $this->cart = $cartService;
    }

    public function confirm()
    {
        $products = $this->cart->contents();
        return view('hadron-frontend::checkout.confirm')->with('products', $products);
    }

    public function payment()
    {
        $products = $this->cart->contents();
        return view('hadron-frontend::checkout.payment')->with('products', $products);
    }

    public function process()
    {
        return redirect('store/complete');
    }

    public function complete()
    {
        $products = $this->cart->contents();
        return view('hadron-frontend::checkout.complete')->with('products', $products);
    }

}
