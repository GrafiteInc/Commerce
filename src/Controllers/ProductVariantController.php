<?php

namespace Quarx\Modules\Hadron\Controllers;

use Quarx;
use Response;
use Illuminate\Http\Request;
use Quarx\Modules\Hadron\Models\Products;
use Yab\Quarx\Controllers\QuarxController;
use Quarx\Modules\Hadron\Repositories\ProductRepository;
use Quarx\Modules\Hadron\Repositories\ProductVariantRepository;

class ProductVariantController extends QuarxController
{
    /** @var ProductsRepository */
    private $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository, ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function variants($id, Request $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Quarx::notification('Product not found', 'warning');

            return redirect(route('quarx.products.index'));
        }

        $this->productVariantRepository->addVariant($product, $request->all());
        Quarx::notification('Variant successfully added.', 'success');

        return redirect(route('quarx.products.edit', $id).'?variants');
    }

    public function saveVariant(Request $request)
    {
        $this->productVariantRepository->saveVariant($request->all());

        return Response::json(['success']);
    }

    public function deleteVariant(Request $request)
    {
        $this->productVariantRepository->deleteVariant($request->all());

        return Response::json(['success']);
    }
}
