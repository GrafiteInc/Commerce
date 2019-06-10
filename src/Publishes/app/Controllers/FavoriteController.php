<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sitec\Commerce\Services\FavoriteService;
use Sitec\Cms\Services\CmsResponseService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService, CmsResponseService $cmsResponseService)
    {
        $this->service = $favoriteService;
        $this->responseService = $cmsResponseService;
    }

    /**
     * List all customer favorites
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $items = $this->service->all();

        if (!is_null($items) && $items->count() > 0) {
            return $this->responseService->apiResponse('success', $items->pluck('product_id'));
        }

        return $this->responseService->apiResponse('success', []);
    }

    /**
     * Add a product to customer favorites
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $result = $this->service->add($request->productId);

        if ($result) {
            return $this->responseService->apiResponse('success', 1);
        }

        return $this->responseService->apiResponse('error', 'Could not be added to Favorites');
    }

    /**
     * Remove a product from customer favories
     *
     * @param  Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $this->service->remove($request->productId);

        return $this->responseService->apiResponse('success', 0);
    }
}
