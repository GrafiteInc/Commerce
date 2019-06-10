<?php

namespace SierraTecnologia\Commerce\Repositories;

use SierraTecnologia\Commerce\Models\Product;
use SierraTecnologia\Commerce\Repositories\FavoriteRepository;
use Illuminate\Support\Facades\Schema;

class ProductRepository
{
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * Returns all Products.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get cusomter favorites
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function favorites()
    {
        $favorites = app(FavoriteRepository::class)->all()->pluck('product_id');

        return $this->model->whereIn('id', $favorites)->get();
    }

    /**
     * Returns all paginated Product.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginated()
    {
        if (isset(request()->dir) && isset(request()->field)) {
            $model = $this->model->orderBy(request()->field, request()->dir);
        } else {
            $model = $this->model->orderBy('created_at', 'desc');
        }

        return $model->paginate(config('cms.pagination', 25));
    }

    /**
     * Search Product.
     *
     * @param string $input
     *
     * @return Product
     */
    public function search($payload, $paginate)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('products');
        $query->where('id', 'LIKE', '%'.$payload.'%');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return $query->paginate($paginate);
    }

    /**
     * Stores Product into database.
     *
     * @param array $input
     *
     * @return Product
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * Find Product by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Product
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Destroy Product.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Product
     */
    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Updates Product in the database.
     *
     * @param int   $id
     * @param array $inputs
     *
     * @return Product
     */
    public function update($id, $inputs)
    {
        $product = $this->model->find($id);
        $product->fill($inputs);
        $product->save();

        return $product;
    }

    /*
    |--------------------------------------------------------------------------
    | Store End
    |--------------------------------------------------------------------------
    */

    /**
     * Get all published products.
     *
     * @return
     */
    public function getPublishedProducts()
    {
        return $this->model->where('is_published', 1);
    }

    /**
     * Find Products by URL.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Products
     */
    public function findProductByURL($url)
    {
        return $this->model->where('url', $url)->where('is_available', 1)->where('is_published', 1)->first();
    }
}
