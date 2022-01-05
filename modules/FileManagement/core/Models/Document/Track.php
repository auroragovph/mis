<?php

namespace Modules\FileManagement\core\Models\Document;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\System\core\Models\Office;

class Track extends Model
{
    protected $guarded = [];
    protected $table   = 'fms_document_tracks';
    public $timestamps = false;

    public function liaison()
    {
        return $this->belongsTo(Employee::class, 'liaison_id');
    }

    public function clerk()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    /*
     * Direct store tracking logs into the database
     */
    public static function log(int $id, string $action, string $purpose, string $status, int $liaison_id = null): self
    {
        return static::create([
            'series_id'  => $id,
            'action'     => $action,
            'purpose'    => $purpose,
            'status'     => $status,
            'liaison_id' => $liaison_id,
            'office_id'  => authenticated('office_id'),
            'user_id'    => authenticated('employee_id'),
        ]);
    }
}
