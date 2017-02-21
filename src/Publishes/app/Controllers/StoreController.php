<?php

namespace App\Http\Controllers\Quazar;

use App\Http\Controllers\Controller;
use Yab\Quazar\Repositories\ProductRepository;
use Yab\Quazar\Services\PlanService;

class StoreController extends Controller
{
    protected $productsRepository;

    public function __construct(ProductRepository $productRepository, PlanService $planService)
    {
        $this->products = $productRepository;
        $this->plans = $planService;
    }

    /**
     * Display the store front.
     *
     * @param int $id
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->products->getPublishedProducts()->paginate(25);
        $plans = $this->plans->allEnabled();

        if (empty($products)) {
            abort(404);
        }

        return view('quazar-frontend::storefront')
            ->with('plans', $plans)
            ->with('products', $products);
    }
}
