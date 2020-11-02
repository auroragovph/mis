<?php

namespace Modules\FileTracking\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FTS_Payroll extends Model
{
    use LogsActivity;
    
    protected $guarded = [];
    protected $table = 'fts_form_payroll';

    protected static $logUnguarded = true;
    protected static $logName = 'fts';
    protected static $logOnlyDirty = true;
}
