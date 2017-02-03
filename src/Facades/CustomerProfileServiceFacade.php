<?php

namespace Yab\Quazar\Facades;

use Illuminate\Support\Facades\Facade;

class CustomerProfileServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CustomerProfileService';
    }
}
