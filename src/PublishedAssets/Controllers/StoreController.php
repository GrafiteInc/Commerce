<?php

namespace App\Http\Controllers\Hadron;

use App\Http\Controllers\Controller;
use Mlantz\Hadron\Repositories\ProductRepository;

class StoreController extends Controller
{

    protected $productsRepository;

    function __construct(ProductRepository $productsRepository)
    {
        $this->repository = $productsRepository;
    }

    /**
     * Display the store homepage
     *
     * @param  int $id
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->repository->getPublishedProducts()->paginate(25);

        if (empty($products)) abort(404);

        return view('hadron-frontend::homepage')->with('products', $products);
    }

}
