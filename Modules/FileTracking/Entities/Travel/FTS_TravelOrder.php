<?php

namespace Modules\FileTracking\Entities\Travel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\Document\FTS_Document;

class FTS_TravelOrder extends Model
{

  

    protected $guarded = [];
    protected $table = 'fts_form_to';
    protected $casts = [
        'employees' => 'array'
    ];

  

    public function document()
    {
        return $this->belongsTo(FTS_Document::class, 'document_id');
    }

    // public function scopeLists($query)
    // {
        
    //     $raws =  $query->select([DB::raw('DISTINCT(employees)')])
    //                 ->get()->pluck('employees');

    //     $lists = array();

    //     foreach($raws as $row){
    //         foreach($row as $emp){
    //             if(!in_array($emp, $lists)){
    //                 array_push($lists, $emp);
    //             }
    //         }
    //     }

    //     return $lists;
    // }

    
}
