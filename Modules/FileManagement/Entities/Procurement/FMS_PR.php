<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_PR extends Model
{

    protected $guarded = [];
    protected $table = 'fms_form_purchase_request';
    protected $casts = [
        'lists' => 'json',
        'properties' => 'json'
    ];

    public function document()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id');
    }
    public function requesting()
    {
        return $this->belongsTo(HR_Employee::class, 'requesting_id');
    }

    public function treasury()
    {
        return $this->belongsTo(HR_Employee::class, 'treasury_id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'approving_id');
    }
    
    
}
