<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Grafite\Commerce\Services\FavoriteService;
use Grafite\Cms\Services\CmsResponseService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService, CmsResponseService $cmsResponseService)
    {
        $this->service = $favoriteService;
        $this->responseService = $cmsResponseService;
    }

    public function all()
    {
        $items = $this->service->all();

        if (!is_null($items) && $items->count() > 0) {
            return $this->responseService->apiResponse('success', $items->pluck('product_id'));
        }

        return $this->responseService->apiResponse('success', []);
    }

    public function add(Request $request)
    {
        $result = $this->service->add($request->productId);

        if ($result) {
            return $this->responseService->apiResponse('success', 1);
        }

        return $this->responseService->apiResponse('error', 'Could not be added to Favorites');
    }

    public function remove(Request $request)
    {
        $this->service->remove($request->productId);

        return $this->responseService->apiResponse('success', 0);
    }
}
