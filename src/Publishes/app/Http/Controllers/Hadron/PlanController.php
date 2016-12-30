<?php

namespace App\Http\Controllers\Hadron;

use App\Http\Controllers\Controller;
use Quarx\Modules\Hadron\Services\PlanService;
use Yab\Crypto\Services\Crypto;

class PlanController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        $this->service = $service;
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

        return view('hadron-frontend::products.all')->with('products', $products);
    }

    /**
     * Display the specified Blog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $plan = $this->service->find(Crypto::decrypt($id));

        if (empty($plan)) {
            abort(404);
        }

        return view('hadron-frontend::plans.show')->with('plan', $plan);
    }
}
