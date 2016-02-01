<?php

namespace Yab\Hadron\Services;

use Quarx;
use Config;
use FileService;
use CryptoService;
use Illuminate\Support\Facades\Auth;
use Yab\Hadron\Repositories\ProductRepository;
use Yab\Hadron\Repositories\ProductVariantRepository;

class ProductService
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->repo = $productRepository;
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function paginated()
    {
        return $this->repo->paginated(Config::get('quarx.pagination', 25));
    }

    public function search($input)
    {
        return $this->repo->search($input, Config::get('quarx.pagination', 25));
    }

    public function create($input)
    {
        $input['url'] = Quarx::convertToURL($input['url']);

        if (isset($input['file'])) {
            $downloadFile = FileService::saveFile($input['file'], 'downloads');
            $input['file'] = $downloadFile['name'];
        } else {
            $input['file'] = '';
        }

        if (isset($input['hero_image'])) {
            $heroFile = FileService::saveFile($input['hero_image'], 'heroes');
            $input['hero_image'] = $heroFile['name'];
        } else {
            $input['hero_image'] = '';
        }

        $input['is_published'] = (isset($input['is_published'])) ? (bool) $input['is_published'] : 0;
        $input['is_available'] = (isset($input['is_available'])) ? (bool) $input['is_available'] : 0;
        $input['is_download'] = (isset($input['is_download'])) ? (bool) $input['is_download'] : 0;
        $input['is_featured'] = (isset($input['is_featured'])) ? (bool) $input['is_featured'] : 0;
        $input['is_subscription'] = (isset($input['is_subscription'])) ? (bool) $input['is_subscription'] : 0;
        $input['has_iterations'] = (isset($input['has_iterations'])) ? (bool) $input['has_iterations'] : 0;

        return $this->repo->create($input);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function update($id, $input)
    {
        $product = $this->repo->find($id);

        $input['url'] = Quarx::convertToURL($input['url']);

        if (isset($input['file'])) {
            $savedFile = FileService::saveFile($input['file'], 'downloads');
            $input['file'] = $savedFile['name'];
        } else {
            $input['file'] = $product->file;
        }

        if (isset($input['hero_image'])) {
            $heroFile = FileService::saveFile($input['hero_image'], 'heroes');
            $input['hero_image'] = $heroFile['name'];
        } else {
            $input['hero_image'] = $product->hero_image;
        }

        $input['is_published'] = (isset($input['is_published'])) ? (bool) $input['is_published'] : 0;
        $input['is_available'] = (isset($input['is_available'])) ? (bool) $input['is_available'] : 0;
        $input['is_download'] = (isset($input['is_download'])) ? (bool) $input['is_download'] : 0;
        $input['is_featured'] = (isset($input['is_featured'])) ? (bool) $input['is_featured'] : 0;
        $input['is_subscription'] = (isset($input['is_subscription'])) ? (bool) $input['is_subscription'] : 0;
        $input['has_iterations'] = (isset($input['has_iterations'])) ? (bool) $input['has_iterations'] : 0;

        return $this->repo->update($id, $input);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Store End
    |--------------------------------------------------------------------------
    */

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