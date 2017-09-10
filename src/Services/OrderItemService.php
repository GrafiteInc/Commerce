<?php

namespace Yab\Quazar\Services;

use Yab\Quazar\Repositories\OrderItemRepository;
use Yab\Quazar\Services\CartService;

class OrderItemService
{
    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->repo = $orderItemRepository;
    }

    /**
     * Get all Orders.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repo->all();
    }

    /**
     * Get all Orders.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated()
    {
        return $this->repo->paginated(config('quarx.pagination', 25));
    }

    /**
     * Find the Order by ID.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function findItemsByOrderId($id)
    {
        return $this->repo->findItemsByOrderId($id);
    }

    /**
     * Search the orders.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        return $this->repo->search($payload, config('quarx.pagination', 25));
    }

    /**
     * Create an order.
     *
     * @param array $payload
     *
     * @return Orders
     */
    public function create($payload)
    {
        return $this->repo->store($payload);
    }

    /**
     * Find an order.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function find($id)
    {
        return $this->repo->model->find($id);
    }

    /**
     * Update an order.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return Orders
     */
    public function update($id, $payload)
    {
        $order = $this->find($id);

        return $this->repo->update($order, $payload);
    }

    /*
     * --------------------------------------------------------------------------
     * Order Item Details
     * --------------------------------------------------------------------------
    */

    /**
     * Get the price details of a product
     *
     * @param  Product $product
     *
     * @return array
     */
    public function getCostDetails($product)
    {
        $cartService = app(CartService::class);

        $subtotal = $cartService->getItemSubtotal($product);
        $shipping = $cartService->getItemShipping($product);
        $tax = $cartService->getItemTax($product);

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $subtotal + $shipping + $tax,
        ];
    }
}
