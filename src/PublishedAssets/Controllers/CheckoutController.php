<?php

namespace App\Http\Controllers\Hadron;

use Quarx;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Hadron\Services\CartService;
use Yab\Hadron\Services\PaymentService;
use Yab\Hadron\Services\QuarxResponseService;

class CheckoutController extends Controller
{
    private $cartService;

    function __construct(CartService $cartService, PaymentService $paymentService)
    {
        $this->cart = $cartService;
        $this->payment = $paymentService;
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

    public function process(Request $request)
    {
        try {
            $response = $this->payment->purchase($request, $this->cart);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

    public function processWithLastCard(Request $request)
    {
        try {
            $response = $this->payment->purchase($request, $this->cart);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

    public function complete()
    {
        $products = $this->cart->contents();
        return view('hadron-frontend::checkout.complete')->with('products', $products);
    }

    public function failed()
    {
        return view('hadron-frontend::checkout.failed');
    }

}
