<?php

namespace Mlantz\Hadron\Services;

use Illuminate\Support\Facades\Auth;
use Mlantz\Hadron\Repositories\ProductRepository;
use Mlantz\Hadron\Repositories\ProductVariantRepository;

class ProductService
{
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public static function productDetails($product)
    {
        return view('hadron-frontend::products.details', ['product' => $product])->render();
    }

    public static function productDetailsBtn($product, $class = '')
    {
        return '<a tabindex="0" class="details '.$class.'" role="button" data-trigger="focus" data-toggle="popover" title="Product Details" data-content=\''. ProductService::productDetails($product).'\'><i class="fa fa-info"></i></a>';
    }

    public static function variants($product)
    {
        $productRepo = new ProductVariantRepository;
        $variants = $productRepo->getProductVariants($product->id)->get();

        $variantHtml = '';

        foreach ($variants as $variant) {
            if (ProductService::isArrayVariant($variant->value)) {
                $variantHtml .= view('hadron-frontend::products.variants.select', [ 'variant' => $variant ])->render();
            } else {
                $variantHtml .= view('hadron-frontend::products.variants.other', [ 'variant' => $variant ])->render();
            }
        }

        return $variantHtml;
    }

    public static function isArrayVariant($value)
    {
        return (count(explode('|', $value)) > 0);
    }

    public static function htmlprep($option)
    {
        // Price adjustments
        preg_match_all('(\(.*\))', $option, $prices);

        if (isset($prices[0][0])) {
            if (! stristr($prices[0][0], '$')) {
                $optionAdjusted = str_replace('+', '+ $', $prices[0][0]);
                $optionAdjusted = str_replace('-', '- $', $optionAdjusted);
            }

            $option = str_replace($prices[0][0], ' '.$optionAdjusted, $option);
        }

        preg_match_all('(\[.*\])', $option, $weight);

        if (isset($weight[0][0])) {
            $option = str_replace($weight[0][0], '', $option);
        }

        return ucfirst($option);
    }

    public static function variantOptions($variant)
    {
        $options = explode('|', $variant->value);
        $optionHtml = '';

        foreach ($options as $option) {
            $optionHtml .= '<option data-variant="'.$variant->id.'" value="'.$option.'">'.ProductService::htmlprep($option).'</option>';
        }

        return $optionHtml;
    }

}