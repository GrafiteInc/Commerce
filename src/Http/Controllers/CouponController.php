<?php

namespace Sitec\Commerce\Http\Controllers;

use Sitec\Cms\Controllers\SitecCmsController;
use Sitec\Commerce\Http\Requests\CouponRequest;
use Sitec\Commerce\Http\Requests\PlanRequest;
use Sitec\Commerce\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends SitecCmsController
{
    public function __construct(CouponService $couponService)
    {
        $this->service = $couponService;
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

        return view('commerce::coupons.index')->with('coupons', $coupons);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $coupons = $this->service->search($request->term);

        return view('commerce::coupons.index')
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
        return view('commerce::coupons.create');
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
            return redirect(config('cms.backend-route-prefix', 'cms').'/coupons/'.$result->id)
                ->with('success', 'Successfully created');
        }

        return redirect('commerce::coupons')->with('error', 'Failed to create');
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

        return view('commerce::coupons.show')
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
            return redirect(config('cms.backend-route-prefix', 'cms').'/coupons')
                ->with('success', 'Successfully deleted');
        }

        return redirect(config('cms.backend-route-prefix', 'cms').'/coupons')
            ->with('error', 'Failed to delete');
    }
}
