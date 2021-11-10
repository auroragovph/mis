<?php

namespace Modules\FileManagement\Entities\Procurement;

// use Modules\System\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Traits\Documents\HasDocument;
use Modules\FileManagement\Traits\Documents\HasFormable;

class PurchaseRequest extends Model
{
    use HasDocument, HasFormable;

    protected $guarded = [];
    protected $table = 'fms_form_purchase_request';

    protected $casts = [
        'lists' => 'json',
        'signatories' => 'json',
        'properties' => 'json'
    ];

    public function getTotalAmountAttribute()
    {
        $lists = collect($this->lists);

        return $lists->sum(function($row){
            $qty = intval($row['quantity'] ?? 0);
            $amount = floatval($row['amount'] ?? 0);
            return $qty  * $amount;
        });
    }
    
}
