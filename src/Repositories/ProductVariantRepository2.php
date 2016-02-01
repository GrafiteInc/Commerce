<?php

namespace Yab\Hadron\Repositories;

use Request;
use FileService;
use Yab\Hadron\Models\Variant;
use Yab\Hadron\Models\Products;
use Illuminate\Support\Facades\Schema;
use Yab\Hadron\Services\QuarxService;

class ProductVariantRepository
{
    /**
     * Get all published products
     * @return
     */
    public function getProductVariants($id)
    {
        return Variant::where('product_id', $id);
    }

    /**
     * Adds variables to the product
     *
     * @param Products $products
     * @param array $input
     *
     * @return Products
     */
    public function addVariants($product, $input)
    {
        $input['product_id'] = $product->id;

        return Variant::create($input);
    }

    public function saveVariant($input)
    {
        $variable = Variant::find($input['id']);

        $variable->key = $input['key'];
        $variable->value = $input['value'];

        return $variable->save();
    }

    public function deleteVariant($input)
    {
        $variable = Variant::find($input['id']);
        return $variable->delete($input);
    }
}