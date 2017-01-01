<?php

namespace Quarx\Modules\Hadron\Services;

use Quarx;
use Config;
use FileService;
use Quarx\Modules\Hadron\Repositories\ProductRepository;
use Quarx\Modules\Hadron\Repositories\ProductVariantRepository;

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

    public function findProductsById($id)
    {
        return $this->repo->findProductsById($id);
    }

    public function search($input)
    {
        return $this->repo->search($input, Config::get('quarx.pagination', 25));
    }

    public function create($payload)
    {
        $payload['url'] = Quarx::convertToURL($payload['url']);

        if (isset($payload['file'])) {
            $downloadFile = FileService::saveFile($payload['file'], 'downloads');
            $payload['file'] = $downloadFile['name'];
        } else {
            $payload['file'] = '';
        }

        if (isset($payload['hero_image'])) {
            $heroFile = FileService::saveFile($payload['hero_image'], 'heroes');
            $payload['hero_image'] = $heroFile['name'];
        } else {
            $payload['hero_image'] = '';
        }

        $payload['price'] = round($payload['price'] * 100);
        $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
        $payload['is_available'] = (isset($payload['is_available'])) ? (bool) $payload['is_available'] : 0;
        $payload['is_download'] = (isset($payload['is_download'])) ? (bool) $payload['is_download'] : 0;
        $payload['is_featured'] = (isset($payload['is_featured'])) ? (bool) $payload['is_featured'] : 0;

        return $this->repo->create($payload);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function update($id, $payload)
    {
        $product = $this->repo->find($id);

        $payload['url'] = Quarx::convertToURL($payload['url']);

        if (isset($payload['hero_image'])) {
            $heroFile = FileService::saveFile($payload['hero_image'], 'heroes');
            $payload['hero_image'] = $heroFile['name'];
        } else {
            $payload['hero_image'] = $product->hero_image;
        }

        $payload['price'] = ($payload['price'] * 100);
        $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
        $payload['is_available'] = (isset($payload['is_available'])) ? (bool) $payload['is_available'] : 0;
        $payload['is_download'] = (isset($payload['is_download'])) ? (bool) $payload['is_download'] : 0;
        $payload['is_featured'] = (isset($payload['is_featured'])) ? (bool) $payload['is_featured'] : 0;

        return $this->repo->update($id, $payload);
    }

    public function updateAlternativeData($id, $payload)
    {
        $product = $this->repo->find($id);

        if (isset($payload['file'])) {
            $savedFile = FileService::saveFile($payload['file'], 'downloads');
            $payload['file'] = $savedFile['name'];
        } else {
            $payload['file'] = $product->file;
        }

        if (!isset($payload['stock']) || empty($payload['stock'])) {
            $payload['stock'] = 0;
        }

        return $this->repo->update($id, $payload);
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
        return '<a tabindex="0" class="details '.$class.'" role="button" data-trigger="focus" data-toggle="popover" title="Product Details" data-content=\''.self::productDetails($product).'\'><i class="fa fa-info"></i></a>';
    }

    public static function variants($product)
    {
        $productRepo = app(ProductVariantRepository::class);
        $variants = $productRepo->getProductVariants($product->id)->get();

        $variantHtml = '';

        foreach ($variants as $variant) {
            if (self::isArrayVariant($variant->value)) {
                $variantHtml .= view('hadron-frontend::products.variants.select', ['variant' => $variant])->render();
            } else {
                $variantHtml .= view('hadron-frontend::products.variants.other', ['variant' => $variant])->render();
            }
        }

        return $variantHtml;
    }

    public static function isArrayVariant($value)
    {
        return count(explode('|', $value)) > 0;
    }

    public static function htmlprep($option)
    {
        // Price adjustments
        preg_match_all('(\(.*\))', $option, $prices);

        if (isset($prices[0][0])) {
            if (!stristr($prices[0][0], '$')) {
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
            $optionHtml .= '<option data-variant="'.$variant->id.'" value="'.$option.'">'.self::htmlprep($option).'</option>';
        }

        return $optionHtml;
    }
}
