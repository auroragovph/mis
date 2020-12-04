<?php

namespace Modules\FileTracking\Entities\Document;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class FTS_Transmittal extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $guarded = [];
    protected $table = 'fts_documents_transmittal';
    public $incrementing = false;

    protected $casts = [
        'documents' => 'json'
    ];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
            $post->office['releasing'] = auth()->user()->employee->division_id;
            $post->employee['releasing'] = auth()->user()->employee_id;
        });
    }

    public function releasingOffice()
    {
        return $this->belongsTo(SYS_Division::class, 'office->releasing', 'id');
    }

    public function receivingOffice()
    {
        return $this->belongsTo(SYS_Division::class, 'office->receiving', 'id');
    }

    public function releasingEmployee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee->releasing', 'id');
    }

    public function receivingEmployee()
    {
        return $this->belongsTo(HR_Employee::class, 'employee->receiving', 'id');
    }

    public function documentsInfo()
    {
        return $this->belongsToJson(FTS_Document::class, 'documents', 'id');
    }






}
