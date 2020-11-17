<?php

namespace Modules\FileTracking\Entities\Travel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FTS_TravelOrder extends Model
{

    use LogsActivity;

    protected $guarded = [];
    protected $table = 'fts_form_travel_order';
    protected $casts = [
        'employees' => 'array'
    ];

    protected static $logUnguarded = true;
    protected static $logName = 'fts';
    protected static $logOnlyDirty = true;


    public function scopeLists($query)
    {
        // return $query->distinct('description')->get();
        $raws =  $query->select([DB::raw('DISTINCT(employees)')])
                    ->get()->pluck('employees');
        $lists = array();
        foreach($raws as $row){foreach($row as $emp){if(!in_array($emp, $lists)){array_push($lists, $emp);}}}

        return $lists;
    }
}
