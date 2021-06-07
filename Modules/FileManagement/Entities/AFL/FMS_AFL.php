<?php

namespace Modules\FileManagement\Entities\AFL;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Traits\Documents\HasDocument;
use Modules\FileManagement\Traits\Documents\HasFormable;

class FMS_AFL extends Model
{
    use HasFormable, HasDocument;
    
    protected $guarded = [];
    protected $table = 'fms_form_afl';

    protected $casts = [
        'properties' => 'json',
        'credits' => 'json',
        'inclusives' => 'json'
    ];

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
