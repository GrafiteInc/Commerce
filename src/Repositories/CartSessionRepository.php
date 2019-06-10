<?php

namespace SierraTecnologia\Commerce\Repositories;

use Illuminate\Support\Facades\Session;
use SierraTecnologia\Commerce\Models\Cart;
use SierraTecnologia\Commerce\Models\Variant;

class CartSessionRepository
{
    public $user;

    public function __construct()
    {
        if (is_null(Session::get('cart'))) {
            Session::put([
                'cart' => [],
                'synced' => false,
            ]);
        }

        $this->user = null;
    }

    /**
     * Get cart contents.
     *
     * @return array
     */
    public function cartContents()
    {
        $contents = [];

        foreach (Session::get('cart') as $item) {
            array_push($contents, json_decode($item));
        }

        return $contents;
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
    public function addToCart($id, $type, $quantity, $variables)
    {
        $cart = Session::get('cart');
        $variableArray = null;

        if (json_decode($variables)) {
            foreach (json_decode($variables) as $variable) {
                $variableFound = Variant::find($variable->variant)->first();
                if ($variableFound && stristr(strtolower($variableFound->value), strtolower($variable->value))) {
                    $variableArray = $variables;
                }
            }
        }

        $match = $this->findMatch([
            'entity_id' => $id,
            'entity_type' => $type,
            'product_variants' => $variableArray,
        ]);

        if ($match) {
            $newQuantity = $match->quantity + $quantity;
            $this->changeItemQuantity($match->id, $newQuantity);
        } else {
            $payload = json_encode([
                'id' => rand(111111, 999999),
                'entity_id' => $id,
                'entity_type' => $type,
                'product_variants' => $variableArray,
                'quantity' => $quantity,
            ]);

            array_push($cart, $payload);

            Session::put('cart', $cart);
        }

        return true;
    }

    /**
     * Find a matching item
     *
     * @param  array $params
     *
     * @return mixed
     */
    public function findMatch($params)
    {
        $cart = Session::get('cart');
        foreach ($cart as $key => $item) {
            $product = json_decode($item);

            if ($product->entity_id == $params['entity_id'] &&
                $product->entity_type == $params['entity_type'] &&
                $product->product_variants == $params['product_variants']
            ) {
                return $product;
            }
        }

        return false;
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
        $cart = Session::get('cart');
        foreach ($cart as $key => $item) {
            $product = json_decode($item);

            if ($product->id == $id) {
                $product->quantity = $quantity;
            }

            $cart[$key] = json_encode($product);
        }

        Session::put('cart', $cart);

        return true;
    }

    /**
     * Remove from cart.
     *
     * @param int    $id
     * @param string $type
     *
     * @return bool
     */
    public function removeFromCart($id)
    {
        $cart = Session::get('cart');

        foreach ($cart as $key => $item) {
            $product = json_decode($item);
            if ($product->id == $id) {
                unset($cart[$key]);
            }
        }

        return Session::put('cart', $cart);
    }

    /**
     * Empty the cart.
     *
     * @return bool
     */
    public function emptyCart()
    {
        return Session::forget('cart');
    }
}
