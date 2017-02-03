<?php

namespace Yab\Quazar\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class QuazarEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.saving: Yab\Quazar\Models\Order' => [
            'Yab\Quazar\Services\OrderService@beforeSave',
        ],

        'eloquent.saved: Yab\Quazar\Models\Order' => [
            'Yab\Quazar\Services\OrderService@afterSave',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot()
    {
        parent::boot();
    }
}
