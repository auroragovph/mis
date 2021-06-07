<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Traits\Documents\HasFormable;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Employee;

class PurchaseOrder extends Model
{
    use HasFormable;
    
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
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function approving()
    {
        return $this->belongsTo(Employee::class, 'approving_id');
    }
}
