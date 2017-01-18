<?php

namespace Yab\Hadron\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Hadron\Services\PlanService;
use Yab\Hadron\Requests\PlanRequest;

class PlanController extends Controller
{
    public function __construct(PlanService $planService)
    {
        $this->service = $planService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->service->collectNewPlans();
        $plans = $this->service->paginated();

        return view('hadron::plans.index')->with('plans', $plans);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $plans = $this->service->search($request->term);

        return view('hadron::plans.index')
            ->with('term', $request->term)
            ->with('plans', $plans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hadron::plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\PlanRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect('quarx/plans/'.$result->id.'/edit')->with('message', 'Successfully created');
        }

        return redirect('hadron::plans')->with('message', 'Failed to create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = $this->service->find($id);
        $customers = $this->service->getSubscribers($plan);

        return view('hadron::plans.edit')
            ->with('customers', $customers)
            ->with('plan', $plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\PlanRequest $request
     * @param int                          $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->service->update($id, $request->except('_token', '_method'));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->with('message', 'Failed to update');
    }

    /**
     * Disable a plan.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function stateChange(Request $request, $id)
    {
        $result = $this->service->stateChange($id, $request->state);

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->with('message', 'Failed to update');
    }

    /**
     * Cancel a subscription.
     *
     * @param int $plan
     * @param int $userMeta
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelSubscription($plan, $userMeta)
    {
        $result = $this->service->cancelSubscription($plan, $userMeta);

        if ($result) {
            return back()->with('message', 'Successfully cancelled');
        }

        return back()->with('message', 'Failed to cancel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect('quarx/plans')->with('message', 'Successfully deleted');
        }

        return redirect('quarx/plans')->with('message', 'Failed to delete');
    }
}
