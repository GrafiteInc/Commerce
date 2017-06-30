<?php

namespace App\Http\Controllers\Quazar;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Quazar\Services\CartService;
use Yab\Quazar\Services\PaymentService;
use Yab\Quazar\Services\CustomerProfileService;

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

        return view('quazar-frontend::checkout.confirm')->with('products', $products);
    }

    public function payment()
    {
        $products = $this->cart->contents();

        return view('quazar-frontend::checkout.payment')->with('products', $products);
    }

    public function addCoupon(Request $request)
    {
        $this->cart->addCoupon($request->coupon);

        return back()->with('message', 'Successfully applied coupon');
    }

    public function removeCoupon()
    {
        $this->cart->removeCoupon();

        return back()->with('message', 'Successfully removed coupon');
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

        return view('quazar-frontend::checkout.complete')->with('products', $products);
    }

    public function failed()
    {
        return view('quazar-frontend::checkout.failed');
    }

    public function reCalculateShipping(Request $request)
    {
        $this->customer->updateProfileAddress(array_merge($request->address, ['shipping' => true]));

        return back()->with('message', 'Successfully updated');
    }
}
