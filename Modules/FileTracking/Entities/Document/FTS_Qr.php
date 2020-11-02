<?php

namespace Modules\FileTracking\Entities\Document;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FTS_Qr extends Model
{
    
    protected $guarded = [];
    protected $table = 'fts_qr';
    protected $casts = [
        'status' => 'boolean'
    ];

    protected static $logUnguarded = true;
    protected static $logName = 'fts';
    protected static $logOnlyDirty = true;

    public function getSeriesAttribute()
    {
        return fts_series($this->id, 'encode');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', false)->get();
    }

    public static function used($id)
    {
        $qr = static::find($id);
        $qr->status = true;
        $qr->save();

        return $qr;
    }



}
