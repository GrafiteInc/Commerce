<?php

namespace App\Http\Controllers\Quazar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Quazar\Services\FavoriteService;
use Yab\Quarx\Services\QuarxResponseService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->service = $favoriteService;
    }

    public function all()
    {
        $items = $this->service->all();

        if (!is_null($items) && $items->count() > 0) {
            return QuarxResponseService::apiResponse('success', $items->pluck('product_id'));
        }

        return QuarxResponseService::apiResponse('success', []);
    }

    public function add(Request $request)
    {
        $result = $this->service->add($request->productId);

        if ($result) {
            return QuarxResponseService::apiResponse('success', 1);
        }

        return QuarxResponseService::apiResponse('error', 'Could not be added to Favorites');
    }

    public function remove(Request $request)
    {
        $this->service->remove($request->productId);

        return QuarxResponseService::apiResponse('success', 0);
    }
}
