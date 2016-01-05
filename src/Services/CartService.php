<?php

namespace Mlantz\Hadron\Services;

use LogisticService;
use Mlantz\Hadron\Models\Variant;
use Illuminate\Support\Facades\Auth;
use Mlantz\Hadron\Repositories\CartRepository;
use Mlantz\Hadron\Repositories\ProductRepository;
use Mlantz\Hadron\Repositories\CartSessionRepository;

class CartService
{

    public function __construct()
    {
        $this->cartRepo = new CartRepository;
        $this->productRepo = new ProductRepository;

        if (is_null(Auth::user())) {
            $this->cartRepo = new CartSessionRepository;
        } else {
            $this->cartRepo->syncronize();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UI
    |--------------------------------------------------------------------------
    */

    public function addToCartBtn($id, $type, $content, $class = '')
    {
        return '<button class="'.$class.'" onclick="store.addToCart('.$id.', 1, \''.$type.'\')">'.$content.'</button>';
    }

    public function removeFromCartBtn($id, $type, $content, $class = '')
    {
        return '<button class="'.$class.'" onclick="store.removeFromCart('.$id.', \''.$type.'\')">'.$content.'</button>';
    }

    /*
    |--------------------------------------------------------------------------
    | Actions and Details
    |--------------------------------------------------------------------------
    */

    public function itemCount()
    {
        $contents = $this->cartRepo->cartContents();
        $total = 0;

        foreach ($contents as $item) {
            $total += $item->quantity;
        }

        return $total;
    }

    public function contents()
    {
        $cartContents = [];
        $contents = $this->cartRepo->cartContents();

        foreach ($contents as $item) {
            $product = $this->productRepo->findProductsById($item->entity_id);
            $product->cart_id = $item->id;
            $product->quantity = $item->quantity;
            $product->entity_type = $item->entity_type;
            $product->weight = $this->weightVariants($item, $product);
            $product->price = $this->priceVariants($item, $product);

            array_push($cartContents, $product);
        }

        return $cartContents;
    }

    public function priceVariants($item, $product)
    {
        $variants = json_decode($item->product_variants);

        if ($variants) {
            foreach ($variants as $variant) {
                if (stristr($variant->value, '(')) {
                    preg_match_all("/\((.*?)\)/", $variant->value, $matches);
                    foreach ($matches[1] as $match) {
                        (float) $product->price += (float) ($match * 100);
                    }
                }
            }
        }

        return (float) $product->price;
    }

    public function weightVariants($item, $product)
    {
        $variants = json_decode($item->product_variants);

        if (!is_null($variants)) {
            foreach ($variants as $variant) {
                if (stristr($variant->value, '[')) {
                    preg_match_all("/\[(.*?)\]/", $variant->value, $matches);
                    foreach ($matches[1] as $match) {
                        (float) $product->weight += (float) $match;
                    }
                }
            }
        }

        if (isset($product->weight)) {
            return (float) $product->weight;
        }

        return 0;
    }

    public function getDefaultValue($variant)
    {
        $matches = explode('|', $variant->value);
        return $matches[0];
    }

    public function getId($variant)
    {
        $variantObject = json_decode($variant);
        return $variantObject->id;
    }

    public function productHasVariants($id)
    {
        return (bool) Variant::where('product_id', $id)->get();
    }

    public function addToCart($id, $type, $quantity, $variants)
    {
        if (empty(json_decode($variants)) && $this->productHasVariants($id)) {
            $variants = [];

            $productVariants = Variant::where('product_id', $id)->get();

            foreach ($productVariants as $variant) {
                array_push($variants, json_encode([
                    'variant' => $this->getId($variant),
                    'value' => $this->getDefaultValue($variant)
                ]));
            }
        }

        return $this->cartRepo->addToCart($id, $type, $quantity, $variants);
    }

    public function changeItemQuantity($id, $count)
    {
        return $this->cartRepo->changeItemQuantity($id, $count);
    }

    public function removeFromCart($id, $type)
    {
        return $this->cartRepo->removeFromCart($id, $type);
    }

    public function emptyCart()
    {
        return $this->cartRepo->emptyCart();
    }

    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    public function getCartTax()
    {
        $taxRate = (LogisticService::getTaxPercent() / 100);
        $subtotal = $this->getCartSubTotal();
        return round($subtotal * $taxRate, 2);
    }

    public function getCartSubTotal()
    {
        $total = 0;
        $contents = $this->cartRepo->cartContents();

        foreach ($contents as $item) {
            $product = $this->productRepo->findProductsById($item->entity_id);
            $this->priceVariants($item, $product);

            $total += $product->price() * $item->quantity;
        }

        return $total;
    }

    public function getCartTotal()
    {
        $taxRate = (LogisticService::getTaxPercent() / 100);
        $subtotal = $this->getCartSubTotal();
        return round($subtotal + LogisticService::shipping(Auth::user()) + ($subtotal * $taxRate), 2);
    }

}