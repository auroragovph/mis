<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FileManagement\Entities\Document\FMS_Document;

class FMS_PO extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_purchase_order';
    protected $casts = [
        'lists' => 'json',
        'supplier' => 'json',
        'delivery' => 'json',
        'pr_number' => 'json'
    ];

    public function document()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id');
    }
}
