<?php

namespace Mlantz\Hadron\Repositories;

use Quarx;
use Request;
use FileService;
use Mlantz\Hadron\Models\Product;
use Mlantz\Hadron\Models\Variant;
use Mlantz\Hadron\Models\Iterations;
use Illuminate\Support\Facades\Schema;

class ProductRepository
{

    /**
     * Returns all Products
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Product::all();
    }

    public function paginated()
    {
        return Product::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($input)
    {
        $query = Product::orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('products');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        };

        return [$query, $input['term'], $query->paginate(25)->render()];
    }


    /**
     * Stores Products into database
     *
     * @param array $input
     *
     * @return Products
     */
    public function store($input)
    {
        $input['url'] = Quarx::convertToURL($input['url']);

        if (isset($input['file'])) {
            $downloadFile = FileService::saveFile($input['file'], 'downloads');
            $input['file'] = $downloadFile['name'];
        }
        if (isset($input['hero_image'])) {
            $heroFile = FileService::saveFile($input['hero_image'], 'heroes');
            $input['hero_image'] = $heroFile['name'];
        }

        return Product::create($input);
    }

    /**
     * Find Products by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Products
     */
    public function findProductsById($id)
    {
        return Product::find($id);
    }

    /**
     * Find Products by URL
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Products
     */
    public function findProductByURL($url)
    {
        return Product::where('url', $url)->where('is_available', 1)->where('is_published', 1)->first();
    }

    /**
     * Get all published products
     * @return
     */
    public function getPublishedProducts()
    {
        return Product::where('is_published', 1);
    }

    /**
     * Updates Products into database
     *
     * @param Products $products
     * @param array $input
     *
     * @return Products
     */
    public function update($product, $input)
    {
        $product->fill($input);
        $product->save();

        return $product;
    }
}