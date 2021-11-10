<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\AwardCommittee\Entities\Procurement\Supplier;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Traits\Documents\HasFormable;

class PurchaseOrder extends Model
{
    use HasFormable;

    protected $guarded = [];
    protected $table   = 'fms_form_purchase_order';
    protected $casts   = [
        'lists'       => 'json',
        'supplier'    => 'json',
        'delivery'    => 'json',
        'pr_number'   => 'json',
        'signatories' => 'json',
    ];

    public function getTotalAmountAttribute()
    {
        $lists = collect($this->lists);
        return $lists->sum(function ($row) {
            $qty    = intval($row['quantity'] ?? 0);
            $amount = floatval($row['amount'] ?? 0);
            return $qty * $amount;
        });
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function supplier_rel()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
