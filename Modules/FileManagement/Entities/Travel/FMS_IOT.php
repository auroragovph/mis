<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_IOT extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_travel_itinerary';
    protected $casts = [
        'properties' => 'json',
        'lists' => 'json'
    ];

    public function document()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id');
    }

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(HR_Employee::class, 'supervisor_id');
    }

    public function head()
    {
        return $this->belongsTo(HR_Employee::class, 'head_id');
    }
}
