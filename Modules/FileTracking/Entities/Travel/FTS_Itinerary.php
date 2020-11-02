<?php

namespace Modules\FileTracking\Entities\Travel;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FTS_Itinerary extends Model
{

    use LogsActivity;

    protected $guarded = [];
    protected $table = 'fts_form_travel_itinerary';

    protected static $logUnguarded = true;
    protected static $logName = 'fts';
    protected static $logOnlyDirty = true;
}
