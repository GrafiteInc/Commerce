<?php

namespace App\Http\Controllers\Quazar;

use Redirect;
use Illuminate\Http\Request;
use Yab\Quazar\Helpers\StoreHelper;
use App\Http\Controllers\Controller;
use Yab\Quazar\Services\CartService;
use Yab\Quarx\Services\QuarxResponseService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cart = $cartService;
    }

    public function getContents()
    {
        $products = $this->cart->contents();

        return view('quazar-frontend::cart.all')->with('products', $products);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX calls
    |--------------------------------------------------------------------------
    */

    public function cart()
    {
        return QuarxResponseService::apiResponse('success', [
            'count' => $this->cart->itemCount(),
            'contents' => $this->cart->contents(),
            'shipping' => StoreHelper::moneyFormat($this->cart->getCartShipping()),
            'coupon' => StoreHelper::moneyFormat($this->cart->getCurrentCouponValue()),
            'tax' => StoreHelper::moneyFormat($this->cart->getCartTax()),
            'subtotal' => StoreHelper::moneyFormat($this->cart->getCartSubTotal()),
            'total' => StoreHelper::moneyFormat($this->cart->getCartTotal()),
        ]);
    }

    public function cartCount()
    {
        $count = $this->cart->itemCount();

        return QuarxResponseService::apiResponse('success', $count);
    }

    public function changeCartCount(Request $request)
    {
        $count = $this->cart->changeItemQuantity($request->id, $request->count);

        return QuarxResponseService::apiResponse('success', $count);
    }

    public function addToCart(Request $request)
    {
        $result = $this->cart->addToCart($request->id, $request->type, $request->quantity, $request->variants);

        if ($result) {
            return QuarxResponseService::apiResponse('success', 'Added to Cart');
        }

        return QuarxResponseService::apiResponse('error', 'Could not be added to Cart');
    }

    public function removeFromCart(Request $request)
    {
        $this->cart->removeFromCart($request->id, $request->type);

        return QuarxResponseService::apiResponse('success', 'Removed from Cart');
    }

    public function emptyCart()
    {
        $this->cart->emptyCart();

        return Redirect::back();
    }
}
