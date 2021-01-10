<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;

class SYS_ActivityLog extends Model
{
    protected $guarded = [];
    protected $table = 'sys_activity_logs';

    protected $casts = [
        'properties' => 'json',
        'agent' => 'json'
    ];

}
