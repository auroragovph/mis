<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_TOL extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [];
    protected $table = 'fms_form_travel_order_lists';

    public function form()
    {
        return $this->belongsTo(FMS_TO::class, 'form_id');
    }

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id');
    }
   
}
