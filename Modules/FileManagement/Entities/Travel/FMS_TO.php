<?php

namespace Modules\FileManagement\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_Document;

class FMS_TO extends Model
{
    protected $guarded = [];
    protected $table = 'fms_form_travel_order';

    protected $casts = [
        'properties' => 'array'
    ];

    public function document()
    {
        return $this->belongsTo(FMS_Document::class, 'document_id');
    }

    public function charging()
    {
        return $this->belongsTo(SYS_Division::class, 'charging_id');
    }

    public function approval()
    {
        return $this->belongsTo(HR_Employee::class, 'approval_id');
    }

    public function lists()
    {
        return $this->hasMany(FMS_TOL::class, 'form_id');
    }
}
