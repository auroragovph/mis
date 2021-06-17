<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Office\SYS_Division;

class Tracking extends Model
{
    // use SoftDeletes;

    protected $guarded = [];
    protected $table = 'fms_documents_tracking';

    public function liaison()
    {
        return $this->belongsTo(Employee::class, 'liaison_id');
    }

    public function clerk()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id');
    }
    
    public static function log($id, $action, $purpose, $status, $liaison_id = null)
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
