<?php

namespace Yab\Hadron\Facades;

use Illuminate\Support\Facades\Facade;

class HadronFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'HadronService'; }
}