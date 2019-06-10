<?php

if (!function_exists('commerce')) {
    function commerce()
    {
        return app(Sitec\Commerce\Services\StoreHelperService::class);
    }
}
