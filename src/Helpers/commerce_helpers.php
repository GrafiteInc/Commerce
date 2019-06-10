<?php

if (!function_exists('commerce')) {
    function commerce()
    {
        return app(SierraTecnologia\Commerce\Services\StoreHelperService::class);
    }
}
