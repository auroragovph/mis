<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;

class FMS_PurchaseOrder extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_purchase_order';

    public function lists()
    {
        return $this->hasMany(FMS_PurchaseOrderData::class, 'pr_id', 'id');
    }
}
