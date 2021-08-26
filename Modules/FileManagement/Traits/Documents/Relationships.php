<?php 

namespace Modules\FileManagement\Traits\Documents;

use Modules\FileManagement\Entities\AFL\Leave;
use Modules\FileManagement\Entities\Cafoa\Cafoa;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;
use Modules\FileManagement\Entities\Procurement\PurchaseRequest;
use Modules\FileManagement\Entities\Travel\Itinerary;
use Modules\FileManagement\Entities\Travel\TravelOrder;

trait Relationships {

    public function afl()
    {
        return $this->hasOne(Leave::class, 'document_id');
    }

    public function cafoa()
    {
        return $this->hasOne(Cafoa::class, 'document_id');

    }

    public function purchase_request()
    {
        return $this->hasOne(PurchaseRequest::class, 'document_id');
    }

    public function purchase_order()
    {
        return $this->hasOne(PurchaseOrder::class, 'document_id');
    }

    public function travel_order()
    {
        return $this->hasOne(TravelOrder::class, 'document_id');
    }

    public function itinerary()
    {
        return $this->hasOne(Itinerary::class, 'document_id');
    }

}