<?php

namespace SierraTecnologia\Commerce\Repositories;

use Illuminate\Support\Facades\Session;
use SierraTecnologia\Commerce\Models\Cart;
use SierraTecnologia\Commerce\Models\Variant;

class CartRepository
{
    public $user;
    public $session;

    public function __construct()
    {
        $this->session = app(Session::class);
        $this->user = auth()->user();
    }

    /**
     * Sync with the session cart.
     */
    public function syncronize()
    {
        $cartContents = Session::get('cart');

        if ($cartContents) {
            foreach ($cartContents as $item) {
                $item = json_decode($item);
                $this->addToCart($item->entity_id, $item->entity_type, $item->quantity, $item->product_variants);
            }
        }

        Session::forget('cart');
    }

    /**
     * Get the cart contents.
     *
     * @return array
     */
    public function cartContents()
    {
        return Cart::where('user_id', $this->user->id)->orderBy('updated_at', 'desc')->get();
    }

    /**
     * Get product count.
     *
     * @param int $id
     *
     * @return int
     */
    public function productCount($id)
    {
        $product = Cart::where('product_id', $id)->where('user_id', $this->user->id)->first();

        if ($product) {
            return $product->quantity;
        }

        return 0;
    }

    /**
     * Get cart item.
     *
     * @param int $id
     *
     * @return obj
     */
    public function getItem($id)
    {
        return Cart::where('id', $id)->where('user_id', $this->user->id)->first();
    }

    /**
     * Add item to cart.
     *
     * @param int    $id
     * @param string $type
     * @param int    $quantity
     * @param string $variants
     *
     * @return bool
     */
    public function addToCart($id, $type, $quantity, $variants)
    {
        $variantArray = null;

        if (json_decode($variants)) {
            foreach (json_decode($variants) as $variant) {
                $variantFound = Variant::find($variant->variant)->first();
                if ($variantFound && stristr(strtolower($variantFound->value), strtolower($variant->value))) {
                    $variantArray = $variants;
                }
            }
        }

        $input = [
            'user_id' => $this->user->id,
            'entity_id' => $id,
            'entity_type' => $type,
            'product_variants' => $variantArray,
        ];

        $item = Cart::where($input)->first();

        if ($item) {
            $item->quantity = (float) $item->quantity + (float) $quantity;
            return $item->save();
        }

        $input['quantity'] = $quantity;
        return Cart::create($input);
    }

    /**
     * Change the item count.
     *
     * @param int $id
     * @param int $quantity
     *
     * @return bool
     */
    public function changeItemQuantity($id, $quantity)
    {
        $item = Cart::where('id', $id)->where('user_id', $this->user->id)->first();
        $item->quantity = $quantity;

        return $item->save();
    }

    /**
     * Remove from cart.
     *
     * @param int    $id
     * @param string $type
     *
     * @return bool
     */
    public function removeFromCart($id, $type)
    {
        $item = Cart::where('id', $id)->where('entity_type', $type)
            ->where('user_id', $this->user->id)->first();

        return $item->delete();
    }

    /**
     * Empty the cart.
     *
     * @return bool
     */
    public function emptyCart()
    {
        return Cart::where('user_id', $this->user->id)->delete();
    }
}
