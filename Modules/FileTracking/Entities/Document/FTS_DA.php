<?php

namespace Modules\FileTracking\Entities\Document;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class FTS_DA extends Model
{
    protected $guarded = [];
    protected $table = 'fts_documents_attachment';
    protected $casts = [
        'properties' => 'array'
    ];

    public function encoder()
    {
        return $this->belongsTo(HR_Employee::class, 'employee_id');
    }

    // public function scopeLists($query)
    // {
    //     // return $query->distinct('description')->get();
    //     return $query->select([DB::raw('DISTINCT(description)')])
    //                 ->get();
    // }
}
