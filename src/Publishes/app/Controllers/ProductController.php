<?php

namespace App\Http\Controllers\Quazar;

use App\Http\Controllers\Controller;
use Yab\Quazar\Repositories\ProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Display all Blog entries.
     *
     * @param int $id
     *
     * @return Response
     */
    public function all()
    {
        $products = $this->repository->getPublishedProducts()->paginate(25);

        if (empty($products)) {
            abort(404);
        }

        return view('quazar-frontend::products.all')->with('products', $products);
    }

    /**
     * Display the specified Blog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($url)
    {
        $product = $this->repository->findProductByURL($url);

        if (empty($product)) {
            abort(404);
        }

        return view('quazar-frontend::products.show')->with('product', $product);
    }
}
