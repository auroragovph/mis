<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Entities\SYS_User;

class HR_Employee extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hrm_employee';

    protected $casts = [
        'name' => 'json',
        'info' => 'json',
        'employement' => 'json'
    ];

    public function scopeLiaison($query)
    {
        return $query->where('liaison', 1);
    }

    public function scopeWhereIdCard($query, $id)
    {
        return $query->where('id_no', $id);
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
