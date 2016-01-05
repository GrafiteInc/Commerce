<?php

namespace App\Http\Controllers\Hadron;

use Quarx;
use Request;
use Redirect;
use App\Http\Controllers\Controller;
use Mlantz\Hadron\Services\CartService;
use Mlantz\Hadron\Services\QuarxResponseService;

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

    public function complete()
    {
        dd("cool");
        // $products = $this->cart->contents();
        // return view('frontend::store.checkout.confirm')->with('products', $products);
    }

}
