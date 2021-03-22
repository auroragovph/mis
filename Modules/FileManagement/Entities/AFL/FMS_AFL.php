<?php

namespace Modules\FileManagement\Entities\AFL;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;

class FMS_AFL extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_afl';

    protected $casts = [
        'properties' => 'json',
        'credits' => 'json',
        'inclusives' => 'json'
    ];

    public function document()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id');
    }

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id');
    }

    public function hr()
    {
        return $this->belongsTo(HR_Employee::class, 'hr_id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'approval_id');
    }
    
}
