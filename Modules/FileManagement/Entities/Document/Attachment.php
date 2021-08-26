<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\Employee\Employee;

class Attachment extends Model
{
    protected $guarded = [];
    protected $table = 'fms_documents_attachment';
    protected $casts = [
        'properties' => 'json'
    ];

    protected static function boot()
    {
        parent::boot();

        Attachment::saving(function ($model) {
            $model->employee_id = authenticated()->employee_id;
            $model->status = 1;
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
