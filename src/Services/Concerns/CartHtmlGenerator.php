<?php

namespace SierraTecnologia\Commerce\Services\Concerns;

trait CartHtmlGenerator
{
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
        return '<button type="button" class="'.$class.'" onclick="store.removeFromCart('.$cartId.', \'product\')">'.$content.'</button>';
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
}
