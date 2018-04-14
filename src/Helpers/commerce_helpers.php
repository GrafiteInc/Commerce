<?php

if (!function_exists('commerce')) {
    function commerce()
    {
        return app(Grafite\Commerce\Services\StoreHelperService::class);
    }
}
