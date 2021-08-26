<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Modules\FileManagement\Entities\Procurement\Air;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // load morph map
        $this->morphMap();
    }


    public function morphMap(): void
    {
        Relation::morphMap([
            'Leave'                     => \Modules\FileManagement\Entities\AFL\Leave::class,

            'CAFOA'                     => \Modules\FileManagement\Entities\Cafoa\Cafoa::class,
            'Travel Order'              => \Modules\FileManagement\Entities\Travel\TravelOrder::class,

            'Purchase Request'          => \Modules\FileManagement\Entities\Procurement\PurchaseRequest::class,
            'Purchase Order'            => \Modules\FileManagement\Entities\Procurement\PurchaseOrder::class,
            'AIR'                       => \Modules\FileManagement\Entities\Procurement\Air::class,
            
        ]);
    }
}
