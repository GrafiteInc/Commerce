<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;
use Yab\Quarx\Services\FileService;
use Yab\Quazar\Services\CartService;
use Yab\Quazar\Services\ProductService;

class Product extends QuarxModel
{
    public $table = 'products';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'name',
        'url',
        'code',
        'price',
        'weight',
        'width',
        'height',
        'discount',
        'notification',
        'discount_type',
        'stock',
        'details',
        'hero_image',
        'is_available',
        'is_published',
        'is_download',
        'is_featured',
        'has_iterations',
        'file',
        'seo_description',
        'seo_keywords',
    ];

    public static $rules = [
        'name' => [
            'required',
        ],
        'price' => [
            'required',
        ],
    ];

    public $appends = [
        'href',
        'file_download_href',
        'hero_image_url',
    ];

    public function getPriceAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getHeroImageUrlAttribute()
    {
        return FileService::fileAsPublicAsset($this->hero_image);
    }

    public function getHrefAttribute()
    {
        return route('quazar.product', [$this->url]);
    }

    public function getFileDownloadHrefAttribute()
    {
        return url(FileService::fileAsDownload($this->file, $this->file));
    }

    public function getVariantsAttribute()
    {
        return app(ProductService::class)->variants($this);
    }

    public function addToCartBtn($content = '', $class = '')
    {
        return app(CartService::class)->addToCartBtn($this, $content, $class);
    }

    public function removeFromCartBtn($cartId, $content = '', $class = '')
    {
        return app(CartService::class)->removeFromCartBtn($cartId, $content, $class);
    }

    public function favoriteToggleBtn($content = '', $notFavorite = '', $isFavorite = '', $class = '')
    {
        return app(CartService::class)->favoriteToggleBtn($this, $content, $notFavorite, $isFavorite, $class);
    }

    public function isFavorite()
    {
        if (auth()->user()) {
           return (auth()->user()->favorites()->pluck('product_id')->contains($this->id)); 
        }
        return false;
    }

    public function details()
    {
        return app(ProductService::class)->productDetails($this);
    }

    public function detailsBtn($class = '')
    {
        return app(ProductService::class)->productDetailsBtn($this, $class);
    }
}
