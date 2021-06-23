<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Employee;

class TravelOrderList extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [];
    protected $table = 'fms_form_travel_order_lists';

    public function form()
    {
        return $this->belongsTo(TravelOrder::class, 'form_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
   
}
