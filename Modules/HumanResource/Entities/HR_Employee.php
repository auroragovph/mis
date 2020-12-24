<?php

namespace Modules\HumanResource\Entities;


use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\SYS_User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Office\SYS_Division;

class HR_Employee extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hrm_employees';

    protected $casts = [
        'name' => 'json',
        'info' => 'array',
        'employment' => 'json',
        'liaison' => 'boolean',
        'properties' => 'json'
    ];

    public function scopeLiaison($query)
    {
        return $query->where('liaison', true);
    }

    public function scopeWhereIdCard($query, $id)
    {
        return $query->where('card', $id);
    }

    public function scopeOnlyDivision($query)
    {
        return $query->where('division_id', Auth::user()->employee->division_id);
    }

    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(SYS_User::class, 'employee_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(HR_Plantilla::class, 'position_id', 'id');
    }
}