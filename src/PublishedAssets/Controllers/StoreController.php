<?php

namespace App\Http\Controllers\Hadron;

use App\Http\Controllers\Controller;
use Quarx\Modules\Hadron\Repositories\ProductRepository;
use Quarx\Modules\Hadron\Services\PlanService;

class StoreController extends Controller
{
    protected $productsRepository;

    public function __construct(ProductRepository $productRepository, PlanService $planService)
    {
        $this->products = $productRepository;
        $this->plans = $planService;
    }

    /**
     * Display the store homepage.
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

        return view('hadron-frontend::homepage')
            ->with('plans', $plans)
            ->with('products', $products);
    }
}
