<?php

namespace Yab\Hadron\Repositories;

use Session;
use Yab\Hadron\Models\Cart;
use Yab\Hadron\Models\Variant;

class CartSessionRepository
{
    public $cart;

    public function __construct()
    {
        if (is_null(Session::get('cart'))) {
            Session::put([
                'cart' => [],
                'synced' => false,
            ]);
        }
    }

    public function cartContents()
    {
        $contents = [];

        foreach (Session::get('cart') as $item) {
            array_push($contents, json_decode($item));
        }

        return $contents;
    }

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

        $payload = json_encode([
            'id' => rand(1111, 9999),
            'entity_id' => $id,
            'entity_type' => $type,
            'product_variants' => $variableArray,
            'quantity' => $quantity,
        ]);

        array_push($cart, $payload);

        Session::put('cart', $cart);

        return true;
    }

    public function changeItemQuantity($id, $quantity)
    {
        foreach (Session::get('cart') as $key => $item) {
            $product = json_decode($item);

            if ($product->id == $id) {
                $product->quantity = $quantity;
            }

            Session::get('cart')[$key] = json_encode($product);
        }

        Session::put('cart', Session::get('cart'));

        return true;
    }

    public function removeFromCart($id)
    {
        foreach (Session::get('cart') as $key => $item) {
            $product = json_decode($item);
            if ($product->id == $id) {
                unset(Session::get('cart')[$key]);
            }
        }

        return Session::put('cart', Session::get('cart'));
    }

    public function emptyCart()
    {
        return Session::forget('cart');
    }
}
