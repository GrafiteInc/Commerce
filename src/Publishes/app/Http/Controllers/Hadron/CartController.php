<?php

namespace App\Http\Controllers\Hadron;

use Request;
use Redirect;
use App\Http\Controllers\Controller;
use Quarx\Modules\Hadron\Services\CartService;
use Yab\Quarx\Services\QuarxResponseService;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cart = $cartService;
    }

    public function getContents()
    {
        $products = $this->cart->contents();

        return view('hadron-frontend::cart.all')->with('products', $products);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX calls
    |--------------------------------------------------------------------------
    */

    public function cartCount()
    {
        $count = $this->cart->itemCount();

        return QuarxResponseService::apiResponse('success', $count);
    }

    public function changeCartCount()
    {
        $count = $this->cart->changeItemQuantity(Request::get('id'), Request::get('count'));

        return QuarxResponseService::apiResponse('success', $count);
    }

    public function addToCart()
    {
        $result = $this->cart->addToCart(Request::get('id'), Request::get('type'), Request::get('quantity'), Request::get('variants'));

        if ($result) {
            return QuarxResponseService::apiResponse('success', 'Added to Cart');
        }

        return QuarxResponseService::apiResponse('error', 'Could not be added to Cart');
    }

    public function removeFromCart()
    {
        $this->cart->removeFromCart(Request::get('id'), Request::get('type'));

        return QuarxResponseService::apiResponse('success', 'Removed from Cart');
    }

    public function emptyCart()
    {
        $this->cart->emptyCart();

        return Redirect::back();
    }
}
