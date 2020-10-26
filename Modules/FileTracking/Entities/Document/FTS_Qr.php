<?php

namespace Modules\FileTracking\Entities\Document;

use Illuminate\Database\Eloquent\Model;

class FTS_Qr extends Model
{
    protected $guarded = [];
    protected $table = 'fts_qr';
    protected $casts = [
        'status' => 'boolean'
    ];

    public function getSeriesAttribute()
    {
        return fts_series($this->id);
    }

}
