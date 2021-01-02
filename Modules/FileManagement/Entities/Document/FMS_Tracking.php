<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class FMS_Tracking extends Model
{
    // use SoftDeletes;

    protected $guarded = [];
    protected $table = 'fms_documents_tracking';

    public function liaison()
    {
        return $this->belongsTo(HR_Employee::class, 'liaison_id', 'id');
    }

    public function clerk()
    {
        return $this->belongsTo(HR_Employee::class, 'user_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id', 'id');
    }



    public static function log($id, $action, $purpose, $status, $liaison_id = 0)
    {
        return static::create([
            'document_id' => $id,
            'action' => $action,
            'purpose' => $purpose,
            'status' => $status,
            'division_id' => Auth::user()->employee->division_id,
            'liaison_id' => $liaison_id,
            'user_id' => Auth::user()->employee_id
        ]);
    }
}
