<?php

namespace Modules\FileTracking\Entities\Document;

use Carbon\Carbon;
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
        'documents' => 'json',
    ];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getIsExpiredAttribute()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->created_at)->addHour();
        return ($now->between($start, $end) == false) ? true : false;
    }

    public function releasingOffice()
    {
        return $this->belongsTo(SYS_Division::class, 'releasing_office');
    }

    public function receivingOffice()
    {
        return $this->belongsTo(SYS_Division::class, 'receiving_office');
    }

    public function releasingEmployee()
    {
        return $this->belongsTo(HR_Employee::class, 'releasing_employee');
    }

    public function receivingEmployee()
    {
        return $this->belongsTo(HR_Employee::class, 'receiving_employee');
    }

    public function documentsInfo()
    {
        return $this->belongsToJson(FTS_Document::class, 'documents', 'id');
    }

}
