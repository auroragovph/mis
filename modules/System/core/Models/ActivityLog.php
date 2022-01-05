<?php

namespace Modules\System\core\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $guarded = [];
    protected $table   = 'sys_activity_logs';

    protected $casts = [
        'properties' => 'json',
        'agent'      => 'json',
    ];

    public function scopeSelf($query)
    {
        return $query->where('employee_id', authenticated('employee_id'))->orderBy('created_at', 'DESC');
    }
}
