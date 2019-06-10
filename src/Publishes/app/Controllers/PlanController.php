<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use SierraTecnologia\Commerce\Services\PlanService;

class PlanController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        if (!config('commerce.subscriptions')) {
            return back()->send();
        }
        $this->service = $service;
    }

    /**
     * Display all plan entries.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $plans = $this->service->allEnabled();

        if (empty($plans)) {
            abort(404);
        }

        return view('commerce-frontend::plans.all')->with('plans', $plans);
    }

    /**
     * Display the specified plan.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = $this->service->findByUuid($id);

        if (empty($plan)) {
            abort(404);
        }

        return view('commerce-frontend::plans.show')->with('plan', $plan);
    }
}
