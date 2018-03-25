<?php

namespace App\Http\Controllers\Commerce;

use Redirect;
use Illuminate\Http\Request;
use Grafite\Commerce\Helpers\StoreHelper;
use App\Http\Controllers\Controller;
use Grafite\Commerce\Services\CartService;
use Grafite\Cms\Services\CmsResponseService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService, CmsResponseService $cmsResponseService)
    {
        $this->cart = $cartService;
        $this->responseService = $cmsResponseService;
    }

    public function getContents()
    {
        $products = $this->cart->contents();

        return view('commerce-frontend::cart.all')->with('products', $products);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX calls
    |--------------------------------------------------------------------------
    */

    public function cart()
    {
        return $this->responseService->apiResponse('success', [
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

        return $this->responseService->apiResponse('success', $count);
    }

    public function changeCartCount(Request $request)
    {
        $count = $this->cart->changeItemQuantity($request->id, $request->count);

        return $this->responseService->apiResponse('success', $count);
    }

    public function addToCart(Request $request)
    {
        $result = $this->cart->addToCart($request->id, $request->type, $request->quantity, $request->variants);

        if ($result) {
            return $this->responseService->apiResponse('success', 'Added to Cart');
        }

        return $this->responseService->apiResponse('error', 'Could not be added to Cart');
    }

    public function removeFromCart(Request $request)
    {
        $this->cart->removeFromCart($request->id, $request->type);

        return $this->responseService->apiResponse('success', 'Removed from Cart');
    }

    public function emptyCart()
    {
        $this->cart->emptyCart();

        return Redirect::back();
    }
}
