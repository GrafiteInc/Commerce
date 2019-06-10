<?php

namespace SierraTecnologia\Commerce\Services;

use SierraTecnologia\Cms\Facades\CmsServiceFacade as Cms;
use Illuminate\Support\Facades\Config;
use SierraTecnologia\Cms\Services\FileService;
use SierraTecnologia\Commerce\Repositories\ProductRepository;
use SierraTecnologia\Commerce\Repositories\ProductVariantRepository;

class ProductService
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->repo = $productRepository;
    }

    /**
     * Get all Products.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repo->all();
    }

    /**
     * Get all products paginated.
     *
     * @return Collection
     */
    public function paginated()
    {
        return $this->repo->paginated(config('cms.pagination', 25));
    }

    /**
     * Search the products.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        return $this->repo->search($payload, config('cms.pagination', 25));
    }

    /**
     * Create a product.
     *
     * @param array $payload
     *
     * @return Product
     */
    public function create($payload)
    {
        $payload['url'] = Cms::convertToURL($payload['url']);

        if (isset($payload['file'])) {
            $downloadFile = app(FileService::class)->saveFile($payload['file'], 'downloads');
            $payload['file'] = $downloadFile['name'];
        } else {
            $payload['file'] = '';
        }

        if (isset($payload['hero_image'])) {
            $heroFile = app(FileService::class)->saveFile($payload['hero_image'], 'heroes', [], true);
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

    /**
     * Find a product.
     *
     * @param int $id
     *
     * @return Product
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Update a product.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return Product
     */
    public function update($id, $payload)
    {
        $product = $this->repo->find($id);

        $payload['url'] = Cms::convertToURL($payload['url']);

        if (isset($payload['hero_image'])) {
            $heroFile = app(FileService::class)->saveFile($payload['hero_image'], 'heroes', [], true);
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

    /**
     * Update the other product data.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return Product
     */
    public function updateAlternativeData($id, $payload)
    {
        $product = $this->repo->find($id);

        if (isset($payload['file'])) {
            $savedFile = app(FileService::class)->saveFile($payload['file'], 'downloads');
            $payload['file'] = $savedFile['name'];
        } else {
            $payload['file'] = $product->file;
        }

        if (!isset($payload['stock']) || empty($payload['stock'])) {
            $payload['stock'] = 0;
        }

        return $this->repo->update($id, $payload);
    }

    /**
     * Destroy a product.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Store End
    |--------------------------------------------------------------------------
    */

    /**
     * Get product details.
     *
     * @param Product $product
     *
     * @return string
     */
    public static function productDetails($product)
    {
        return view('commerce-frontend::products.details', ['product' => $product])->render();
    }

    /**
     * Product detauls button.
     *
     * @param Product $product
     * @param string  $class
     *
     * @return string
     */
    public static function productDetailsBtn($product, $class = '')
    {
        return '<a tabindex="0" class="details '.$class.'" role="button" data-trigger="focus" data-toggle="popover" title="Product Details" data-content=\''.self::productDetails($product).'\'><i class="fa fa-info"></i></a>';
    }

    /**
     * Product variants.
     *
     * @param Product $product
     *
     * @return string
     */
    public static function variants($product)
    {
        $productRepo = app(ProductVariantRepository::class);
        $variants = $productRepo->getProductVariants($product->id)->get();

        $variantHtml = '';

        foreach ($variants as $variant) {
            if (self::isArrayVariant($variant->value)) {
                $variantHtml .= view('commerce-frontend::products.variants.select', ['variant' => $variant])->render();
            } else {
                $variantHtml .= view('commerce-frontend::products.variants.other', ['variant' => $variant])->render();
            }
        }

        return $variantHtml;
    }

    /**
     * Check if variat is array.
     *
     * @param string $value
     *
     * @return bool
     */
    public static function isArrayVariant($value)
    {
        return count(explode('|', $value)) > 0;
    }

    /**
     * Prepare variant HTML.
     *
     * @param string $option
     *
     * @return string
     */
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

    /**
     * Create the product variant options.
     *
     * @param Variant $variant
     *
     * @return string
     */
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
