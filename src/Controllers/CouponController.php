<?php

namespace Yab\Quazar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yab\Quazar\Requests\CouponRequest;
use Yab\Quazar\Requests\PlanRequest;
use Yab\Quazar\Services\CouponService;

class CouponController extends Controller
{
    public function __construct(CouponService $planService)
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
        // $this->service->collectNewCoupons();
        $coupons = $this->service->paginated();

        return view('quazar::coupons.index')->with('coupons', $coupons);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $coupons = $this->service->search($request->term);

        return view('quazar::coupons.index')
            ->with('term', $request->term)
            ->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quazar::coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\CouponRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(config('quarx.backend-route-prefix', 'quarx').'/coupons/'.$result->id)->with('message', 'Successfully created');
        }

        return redirect('quazar::coupons')->with('error', 'Failed to create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = $this->service->find($id);

        return view('quazar::coupons.show')
            ->with('coupon', $coupon);
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
            return redirect(config('quarx.backend-route-prefix', 'quarx').'/coupons')->with('message', 'Successfully deleted');
        }

        return redirect(config('quarx.backend-route-prefix', 'quarx').'/coupons')->with('error', 'Failed to delete');
    }
}
