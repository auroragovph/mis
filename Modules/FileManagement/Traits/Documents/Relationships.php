<?php 

namespace Modules\FileManagement\Traits\Documents;

trait Relationships {

    public function afl()
    {
        return $this->hasOne(FMS_AFL::class, 'document_id', 'id');
    }

    public function cafoa()
    {
        return $this->hasOne(FMS_Cafoa::class, 'document_id', 'id');
    }

    public function purchase_request()
    {
        return $this->hasOne(FMS_PurchaseRequest::class, 'document_id', 'id');
    }

    // public function obligation_request()
    // {
    //     return $this->hasOne(FMS_ObligationRequest::class, 'document_id', 'id');
    // }
    

    public function travel_order()
    {
        return $this->hasOne(FMS_TravelOrder::class, 'document_id', 'id');
    }

    public function itinerary()
    {
        return $this->hasOne(FMS_Itinerary::class, 'document_id', 'id');
    }

}