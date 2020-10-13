<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_Itinerary extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $guarded = [];
    protected $table = 'fms_form_travel_itinerary';
    protected $casts = [
        'properties' => 'array',
        'lists' => 'array',
        'signatories' => 'json'
    ];

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->supervisor', 'id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'signatories->approval', 'id');
    }
}
