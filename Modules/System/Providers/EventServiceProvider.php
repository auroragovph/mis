<?php

namespace Modules\System\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
     /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerObservers();
    }

    public function registerObservers()
    {
        \Modules\System\Entities\Office\Office::observe(\Modules\System\Observers\Office\OfficeObserver::class);
    }
}