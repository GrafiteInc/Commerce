<?php

namespace Yab\Hadron\Repositories;

use Yab\Hadron\Models\Variant;
use Yab\Hadron\Models\Product;

class ProductVariantRepository
{
    /**
     * Get all published products.
     *
     * @return
     */
    public function getProductVariants($id)
    {
        return Variant::where('product_id', $id);
    }

    /**
     * Adds variables to the product.
     *
     * @param Products $products
     * @param array    $input
     *
     * @return Products
     */
    public function addVariant($product, $input)
    {
        $input['product_id'] = $product->id;

        return Variant::create($input);
    }

    /**
     * Save the variant.
     *
     * @param [type] $input [description]
     *
     * @return [type] [description]
     */
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
