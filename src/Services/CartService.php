<?php

namespace Yab\Quazar\Services;

use App\Services\StoreLogistics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yab\Quazar\Models\Coupon;
use Yab\Quazar\Models\Variant;
use Yab\Quazar\Repositories\CartRepository;
use Yab\Quazar\Repositories\CartSessionRepository;
use Yab\Quazar\Repositories\TransactionRepository;

class CartService
{
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Set the cart repo.
     *
     * @return mixed
     */
    public function cartRepo()
    {
        $repo = null;

        if (is_null(auth()->user())) {
            $repo = app(CartSessionRepository::class);
        } else {
            $repo = app(CartRepository::class);
            $repo->syncronize();
        }

        return $repo;
    }

    /*
    |--------------------------------------------------------------------------
    | UI
    |--------------------------------------------------------------------------
    */

    /**
     * Add to cart button.
     *
     * @param int    $id
     * @param string $content
     * @param string $class
     *
     * @return string
     */
    public function addToCartBtn($product, $content, $class = '')
    {
        return '<button class="'.$class.'" onclick="store.addToCart('.$product->id.', 1, \'product\')">'.$content.'</button>';
    }

    /**
     * Remove from cart button.
     *
     * @param int    $id
     * @param string $content
     * @param string $class
     *
     * @return string
     */
    public function removeFromCartBtn($cartId, $content, $class = '')
    {
        return '<button class="'.$class.'" onclick="store.removeFromCart('.$cartId.', \'product\')">'.$content.'</button>';
    }

    /**
     *  Favorites toggle button.
     *
     * @param int    $id
     * @param string $content
     * @param string $notFavorite
     * @param string $isFavorite
     * @param string $class
     *
     * @return string
     */
    public function favoriteToggleBtn($product, $content, $notFavorite, $isFavorite, $class = '')
    {
        $button = '';

        if (auth()->user()) {
            if (auth()->user()->favorites()->pluck('product_id')->contains($product->id)) {
                $buttonContent = $content.' '.$isFavorite;
                $requestUrl = url("/store/favorites/remove/".$product->id);
            } else {
                $buttonContent = $content.' '.$notFavorite;
                $requestUrl = url("/store/favorites/add/".$product->id);
            }

            $button = '<button class="'.$class.'" onclick="store.favoriteToggle('.$product->id.', this, \''.$content.'\', \''.e($isFavorite).'\', \''.e($notFavorite).'\')" data-url="'.$requestUrl.'">'.$buttonContent.'</button>';
        }

        return $button;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions and Details
    |--------------------------------------------------------------------------
    */

    /**
     * Get the cart item count.
     *
     * @return int
     */
    public function itemCount()
    {
        $contents = $this->cartRepo()->cartContents();

        $total = 0;

        foreach ($contents as $item) {
            $total += $item->quantity;
        }

        return $total;
    }

    /**
     * Get the cart contents.
     *
     * @return array
     */
    public function contents()
    {
        $cartContents = [];
        $contents = $this->cartRepo()->cartContents();

        foreach ($contents as $item) {
            $product = $this->service->find($item->entity_id);
            $product->cart_id = $item->id;
            $product->quantity = $item->quantity;
            $product->entity_type = $item->entity_type;
            $product->weight = $this->weightVariants($item, $product);
            $product->price = $this->priceVariants($item, $product);

            array_push($cartContents, $product);
        }

        return $cartContents;
    }

    /**
     * Get the price variants.
     *
     * @param obj     $item
     * @param Product $product
     *
     * @return float
     */
    public function priceVariants($item, $product)
    {
        $variants = json_decode($item->product_variants);

        if ($variants) {
            foreach ($variants as $variant) {
                if (stristr($variant->value, '(')) {
                    preg_match_all("/\((.*?)\)/", $variant->value, $matches);
                    foreach ($matches[1] as $match) {
                        $price = (float) $product->price * 100;
                        $price += (float) ($match * 100);
                        $product->price = $price;
                    }
                }
            }
        }

        return (float) $product->price * 100;
    }

    /**
     * Get the weight variants.
     *
     * @param obj     $item
     * @param Product $product
     *
     * @return float
     */
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

    /**
     * Get the default value.
     *
     * @param Variant $variant
     *
     * @return string
     */
    public function getDefaultValue($variant)
    {
        $matches = explode('|', $variant->value);

        return $matches[0];
    }

    /**
     * Get a variant ID.
     *
     * @param Variant $variant
     *
     * @return int
     */
    public function getId($variant)
    {
        $variantObject = json_decode($variant);

        return $variantObject->id;
    }

    /**
     * Check if product has variants.
     *
     * @param int $id
     *
     * @return bool
     */
    public function productHasVariants($id)
    {
        return (bool) Variant::where('product_id', $id)->get();
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
        if (empty(json_decode($variants)) && $this->productHasVariants($id)) {
            $variants = [];

            $productVariants = Variant::where('product_id', $id)->get();

            foreach ($productVariants as $variant) {
                array_push($variants, json_encode([
                    'variant' => $this->getId($variant),
                    'value' => $this->getDefaultValue($variant),
                ]));
            }
        }

        return $this->cartRepo()->addToCart($id, $type, $quantity, $variants);
    }

    /**
     * Change the item quantity.
     *
     * @param int $id
     * @param int $count
     *
     * @return bool
     */
    public function changeItemQuantity($id, $count)
    {
        return $this->cartRepo()->changeItemQuantity($id, $count);
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
        return $this->cartRepo()->removeFromCart($id, $type);
    }

    /**
     * Empty the cart.
     *
     * @return bool
     */
    public function emptyCart()
    {
        return $this->cartRepo()->emptyCart();
    }

    /**
     * Add coupon
     *
     * @param void
     */
    public function addCoupon($couponCode)
    {
        $coupon = app(Coupon::class)->where('code', $couponCode)->first();

        if (app(TransactionRepository::class)->getByCustomer(auth()->id())->where('coupon->code', $couponCode)->count() < $coupon->limit) {
            Session::put('coupon_code', $couponCode);
        } else {
            Session::flash('message', 'Coupon is no longer valid');
        }
    }

    /**
     * Remove coupon
     *
     * @param void
     */
    public function removeCoupon()
    {
        Session::forget('coupon_code');
    }

    /**
     * Get the current coupon code
     *
     * @return integer
     */
    public function getCurrentCouponValue($code = null)
    {
        $value = 0;

        if (is_null($code)) {
            $code = Session::get('coupon_code');
        }

        $coupon = app(CouponService::class)->findByStripeId($code);

        if ($coupon) {
            if ($coupon->discount_type == 'dollar') {
                $value = $coupon->dollars;
            } else {
                $percentage = $coupon->dollars / 100;
                $value = $this->total() * $percentage;
            }
        }

        return round($value, 2);
    }

    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    /**
     * Get the cart tax.
     *
     * @return float
     */
    public function getCartTax()
    {
        $taxRate = (app(LogisticService::class)->getTaxPercent(auth()->user()) / 100);
        $subtotal = $this->getCartSubTotal();

        return round($subtotal * $taxRate, 2);
    }

    /**
     * Get cart subtotal.
     *
     * @return float
     */
    public function getCartSubTotal()
    {
        $total = 0;
        $contents = $this->cartRepo()->cartContents();

        foreach ($contents as $item) {
            $product = $this->service->find($item->entity_id);
            $this->priceVariants($item, $product);

            $total += $product->price * $item->quantity;
        }

        if (config('quazar.taxes_include_shipping')) {
            $total += app(StoreLogistics::class)->shipping($this->cartRepo()->user);
        }

        return round($total, 2);
    }

    /**
     * Get the cart total.
     *
     * @return float
     */
    public function getCartTotal()
    {
        $taxRate = (app(LogisticService::class)->getTaxPercent(auth()->user()) / 100);
        $subtotal = $this->getCartSubTotal();

        $total = $subtotal + app(LogisticService::class)->shipping(auth()->user()) + ($subtotal * $taxRate);
        $total = $total - $this->getCurrentCouponValue();

        return round($total, 2);
    }
}
