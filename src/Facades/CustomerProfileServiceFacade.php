<?php

namespace Quarx\Modules\Hadron\Facades;

use Illuminate\Support\Facades\Facade;

class CustomerProfileServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CustomerProfileService';
    }
}
