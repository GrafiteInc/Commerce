<?php

namespace Mlantz\Hadron\Facades;

use Illuminate\Support\Facades\Facade;

class HadronFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'HadronService'; }
}