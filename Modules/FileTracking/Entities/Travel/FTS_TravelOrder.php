<?php

namespace Modules\FileTracking\Entities\Travel;

use Illuminate\Database\Eloquent\Model;

class FTS_TravelOrder extends Model
{
    protected $guarded = [];
    protected $table = 'fts_form_travel_order';
    protected $casts = [
        'employees' => 'array'
    ];
}
