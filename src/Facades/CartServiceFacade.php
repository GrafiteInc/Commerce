<?php

namespace SierraTecnologia\Commerce\Facades;

use Illuminate\Support\Facades\Facade;

class CartServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CartService';
    }
}
