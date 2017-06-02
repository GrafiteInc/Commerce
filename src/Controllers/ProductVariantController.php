<?php

namespace Yab\Quazar\Controllers;

use Quarx;
use Response;
use Illuminate\Http\Request;
use Yab\Quazar\Models\Products;
use Yab\Quarx\Controllers\QuarxController;
use Yab\Quazar\Repositories\ProductRepository;
use Yab\Quazar\Repositories\ProductVariantRepository;

class ProductVariantController extends QuarxController
{
    /**
     * Product Repository.
     *
     * @var Yab\Quazar\Repositories\ProductRepository
     */
    public $productRepository;

    /**
     * Product Variant Repository.
     *
     * @var Yab\Quazar\Repositories\ProductVariantRepository
     */
    public $productVariantRepository;

    public function __construct(
        ProductVariantRepository $productVariantRepository,
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * Get a product's variants.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function variants($id, Request $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Quarx::notification('Product not found', 'warning');

            return redirect(route('quarx.products.index'));
        }

        if ($this->productVariantRepository->addVariant($product, $request->all())) {
            Quarx::notification('Variant successfully added.', 'success');
        } else {
            Quarx::notification('Failed to add variant. Missing Key or Value.', 'warning');
        }

        return redirect(route(config('quarx.backend-route-prefix', 'quarx').'.products.edit', $id).'?tab=variants');
    }

    /**
     * Save a variant.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function saveVariant(Request $request)
    {
        $this->productVariantRepository->saveVariant($request->all());

        return Response::json(['success']);
    }

    /**
     * Delete a variant.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function deleteVariant(Request $request)
    {
        $this->productVariantRepository->deleteVariant($request->all());

        return Response::json(['success']);
    }
}
