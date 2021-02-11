<?php 

namespace Modules\FileManagement\Traits\Documents;

use Modules\FileManagement\Entities\Procurement\FMS_PO;
use Modules\FileManagement\Entities\Procurement\FMS_PR;

trait Relationships {

    public function afl()
    {
        return $this->hasOne(FMS_AFL::class, 'document_id');
    }

    public function cafoa()
    {
        return $this->hasOne(FMS_Cafoa::class, 'document_id');
    }

    public function purchase_request()
    {
        return $this->hasOne(FMS_PR::class, 'document_id');
    }

    public function purchase_order()
    {
        return $this->hasOne(FMS_PO::class, 'document_id');
    }

    public function travel_order()
    {
        return $this->hasOne(FMS_TravelOrder::class, 'document_id');
    }

    public function itinerary()
    {
        return $this->hasOne(FMS_Itinerary::class, 'document_id');
    }

}