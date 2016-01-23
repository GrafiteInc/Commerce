<?php

namespace Mlantz\Hadron\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class HadronEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.saving: Mlantz\Hadron\Models\Order' => [
            'Mlantz\Hadron\Services\OrderService@beforeSave',
        ],

        'eloquent.saved: Mlantz\Hadron\Models\Order' => [
            'Mlantz\Hadron\Services\OrderService@afterSave',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
