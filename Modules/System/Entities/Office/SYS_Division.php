<?php

namespace Modules\System\Entities\Office;

use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;

class SYS_Division extends Model
{
    protected $guarded = [];
    protected $table = 'sys_division';

    public function scopeLists($query)
    {
        return $query->with('office')->get();
    }

    public function office()
    {
        return $this->belongsTo(SYS_Office::class, 'office_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(HR_Employee::class, 'division_id', 'id');
    }
}
