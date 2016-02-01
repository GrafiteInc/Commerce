<?php

namespace Yab\Hadron\Repositories;

use Yab\Hadron\Models\CustomerProfile;

class CustomerProfileRepository
{
    public function __construct(CustomerProfile $customerProfile)
    {
        $this->model = $customerProfile;
    }

    /**
     * Stores Product into database
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
     * Find Product by given id
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
     * Find customer profile by user
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Product
     */
    public function getCustomerProfile($id)
    {
        return $this->model->where('user_id', $id)->first();
    }

    /**
     * Find Product by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Product
     */
    public function findByUserId($id)
    {
        return $this->model->firstOrCreate([ 'user_id' => $id ]);
    }

    /**
     * Destroy Product
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
     * Updates Product in the database
     *
     * @param int $id
     * @param array $inputs
     *
     * @return Product
     */
    public function updateProfile($id, $inputs)
    {
        $profile = $this->model->find($id);
        $profile->fill($inputs);
        return $profile->save();
    }
}