<?php

namespace Modules\FileManagement\core\Models\Document;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\core\Models\Employee\Employee;

class Form extends Model
{
    protected $guarded = [];
    protected $table   = 'fms_document_form';

    public function formable()
    {
        return $this->morphTo();
    }

    public function encoder()
    {
        return $this->belongsTo(Employee::class, 'encoder_id');
    }
}
