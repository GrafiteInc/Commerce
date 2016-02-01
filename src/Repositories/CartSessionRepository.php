<?php

namespace Yab\Hadron\Repositories;

use Auth;
use Session;
use Yab\Hadron\Models\Cart;
use Yab\Hadron\Services\Quarx;
use Illuminate\Support\Facades\Schema;
use Yab\Hadron\Models\Variants;

class CartSessionRepository
{
    public function __construct()
    {
        if (is_null(Session::get('cart'))) {
            Session::put([
                'cart' => [],
                'synced' => false
            ]);
        }

        $this->cart = Session::get('cart');
    }

    public function cartContents()
    {
        $contents = [];

        foreach ($this->cart as $item) {
            array_push($contents, json_decode($item));
        }

        return $contents;
    }

    public function addToCart($id, $type, $quantity, $variables)
    {
        $variableArray = null;

        if (json_decode($variables)) {
            foreach (json_decode($variables) as $variable) {
                $variableFound = Variants::find($variable->variable)->first();
                if ($variableFound && stristr(strtolower($variableFound->value), strtolower($variable->value))) {
                    $variableArray = $variables;
                }
            }
        }

        $input = json_encode([
            'id' => rand(1111, 9999),
            'entity_id' => $id,
            'entity_type' => $type,
            'product_variants' => $variableArray,
            'quantity' => $quantity,
        ]);

        array_push($this->cart, $input);

        Session::put('cart', $this->cart);

        return true;
    }

    public function changeItemQuantity($id, $quantity)
    {
        foreach ($this->cart as $key => $item) {
            $product = json_decode($item);

            if ($product->id == $id) {
                $product->quantity = $quantity;
            }

            $this->cart[$key] = json_encode($product);
        }

        Session::put('cart', $this->cart);

        return true;
    }

    public function removeFromCart($id)
    {
        foreach ($this->cart as $key => $item) {
            $product = json_decode($item);
            if ($product->id == $id) {
                unset($this->cart[$key]);
            }
        }

        return Session::put('cart', $this->cart);
    }

    public function emptyCart()
    {
        return Session::forget('cart');
    }

}