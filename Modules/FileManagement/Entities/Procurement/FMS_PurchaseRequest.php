<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class FMS_PurchaseRequest extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_purchase_request';

    public function lists()
    {
        return $this->hasMany(FMS_PurchaseRequestData::class, 'pr_id', 'id');
    }

    public function requesting()
    {
        return $this->belongsTo(HR_Employee::class, 'requesting_id', 'id');
    }

    public function charging()
    {
        return $this->belongsTo(SYS_Division::class, 'charging_id', 'id');
    }
}
