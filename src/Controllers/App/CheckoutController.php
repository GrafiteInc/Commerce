<?php

namespace Yab\Hadron\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Hadron\Services\CartService;
use Yab\Hadron\Services\PaymentService;
use Yab\Hadron\Services\CustomerProfileService;

class CheckoutController extends Controller
{
    public function __construct(CartService $cartService, PaymentService $paymentService, CustomerProfileService $customer)
    {
        $this->cart = $cartService;
        $this->payment = $paymentService;
        $this->customer = $customer;
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
            $response = $this->payment->purchase($request->input('stripeToken'), $this->cart);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

    public function processWithLastCard(Request $request)
    {
        try {
            $response = $this->payment->purchase($request->input('stripeToken'), $this->cart);
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

    public function reCalculateShipping(Request $request)
    {
        $this->customer->updateProfileAddress(array_merge($request->address, ['shipping' => true]));

        return back()->with('message', 'Successfully updated');
    }
}
