<?php

namespace Modules\FileManagement\Entities\Cafoa;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FileManagement\Entities\Document\FMS_Document;

class FMS_Cafoa extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_cafoa';
    protected $casts = [
        'lists' => 'json',
        'ledger' => 'collection'
    ];

    public function document()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id');
    }

    public function onlyDivision()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id')->onlyDivision();
    }

    public function requesting()
    {
        return $this->belongsTo(HR_Employee::class, 'requesting_id');
    }

    public function budget()
    {
        return $this->belongsTo(HR_Employee::class, 'budget_id');
    }

    public function accounting()
    {
        return $this->belongsTo(HR_Employee::class, 'accountant_id');
    }

    public function treasury()
    {
        return $this->belongsTo(HR_Employee::class, 'treasury_id');
    }
}
