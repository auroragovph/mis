<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Office\Division;
use Modules\HumanResource\Entities\Employee\Employee;

class Track extends Model
{

    protected $guarded = [];
    protected $table = 'fms_documents_tracks';
    public $timestamps = false;


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
        return $this->belongsTo(Division::class, 'division_id');
    }
    
    /*
    * Direct store tracking logs into the database
    */
    public static function log(int $id, int $action, string $purpose, int $status, int $liaison_id = null): self
    {
        return static::create([
            'document_id' => $id,
            'action' => $action,
            'purpose' => $purpose,
            'status' => $status,
            'liaison_id' => $liaison_id,
            'division_id' => authenticated()->employee->division_id,
            'user_id' => authenticated()->employee_id
        ]);
    }
}
