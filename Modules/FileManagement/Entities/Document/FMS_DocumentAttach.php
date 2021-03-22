<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FMS_DocumentAttach extends Model
{
    protected $guarded = [];
    protected $table = 'fms_documents_attachment';
    protected $casts = [
        'properties' => 'json'
    ];

    protected static function boot()
    {
        parent::boot();

        FMS_DocumentAttach::saving(function ($model) {
            $model->employee_id = authenticated()->employee_id;
            $model->status = 1;
        });
    }

    public function employee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id', 'id');
    }
}
