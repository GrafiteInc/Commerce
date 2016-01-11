<?php

namespace Mlantz\Hadron\Services;

use Quarx;
use Config;
use FileService;
use CryptoService;

class HadronService
{

    public function __construct()
    {

    }

    public function config($key)
    {
        $splitKey = explode('.', $key);

        $moduleConfig = include(__DIR__.'/../Config/'.$splitKey[0].'.php');

        $strippedKey = preg_replace('/'.$splitKey[1].'./', '', preg_replace('/'.$splitKey[0].'./', '', $key, 1), 1);

        return $moduleConfig[$strippedKey];
    }

    public function asset($path, $type)
    {
        $path = __DIR__.'/../Assets/'.$path;
        return Quarx::asset($path, $type).'?isModule=true';
    }



}