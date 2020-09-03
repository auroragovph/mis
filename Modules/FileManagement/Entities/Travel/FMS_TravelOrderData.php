<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_TravelOrderData extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_travel_order_data';


    public function travel()
    {
        return $this->belongsTo(FMS_TravelOrder::class, 'travel_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id', 'id');
    }
}
