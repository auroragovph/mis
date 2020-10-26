<?php

namespace Modules\FileManagement\Entities\AFL;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_AFL extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $guarded = [];
    protected $table = 'fms_form_afl';

    protected $casts = [
        'properties' => 'array',
        'credits' => 'array',
        'inclusives' => 'array',
        'signatories' => 'json'
    ];

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id', 'id');
    }

    public function hr()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->approval', 'id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->hr', 'id');
    }
}