<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use Sitec\Commerce\Repositories\ProductRepository;
use Sitec\Commerce\Services\PlanService;

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

        return view('commerce-frontend::storefront')
            ->with('plans', $plans)
            ->with('products', $products);
    }
}
