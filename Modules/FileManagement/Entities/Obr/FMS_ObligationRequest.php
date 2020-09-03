<?php

namespace Modules\FileManagement\Entities\Obr;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_ObligationRequest extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_obr';
    protected $casts = ['lists' => 'collection'];

    public function lists()
    {
        return $this->hasMany(FMS_ObligationRequestData::class, 'obr_id', 'id');
    }

    public function dh()
    {
        return $this->belongsTo(HR_Employee::class, 'dh_id', 'id');
    }

    public function bo()
    {
        return $this->belongsTo(HR_Employee::class, 'bo_id', 'id');
    }
}


