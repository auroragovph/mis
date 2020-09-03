<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;

class FMS_PurchaseOrder extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_purchase_order';
    protected $casts = [
        'supplier' => 'array',
        'delivery' => 'array',
        'lists' => 'collection',
    ];

    
}
