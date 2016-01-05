<?php

namespace App\Http\Controllers\Hadron;

use Quarx;
use App\Http\Controllers\Controller;
use Mlantz\Hadron\Services\CartService;
use Mlantz\Hadron\Services\QuarxResponseService;
use Mlantz\Hadron\Repositories\ProductRepository;

class ProductController extends Controller
{

    private $productRepository;

    function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Display all Blog entries.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function all()
    {
        $products = $this->repository->getPublishedProducts()->paginate(25);

        if (empty($products)) abort(404);

        return view('hadron-frontend::products.all')->with('products', $products);
    }

    /**
     * Display the specified Blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($url)
    {
        $product = $this->repository->findProductByURL($url);

        if (empty($product)) abort(404);

        return view('hadron-frontend::products.show')->with('product', $product);
    }

}
