<?php

namespace Modules\FileTracking\Entities;

use Illuminate\Database\Eloquent\Model;

class FTS_AFL extends Model
{
    protected $guarded = [];
    protected $table = 'fts_form_afl';
    protected $casts = [
        'inclusives' => 'array',
        'leave' => 'array'
    ];
}
