<?php

namespace Modules\HumanResource\Entities;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Database\factories\EmployeeFactory;
use Modules\System\Entities\Office\SYS_Division;

class HR_Employee extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'hrm_employees';

    protected $casts = [
        'name' => 'json',
        'info' => 'array',
        'employment' => 'json',
        'liaison' => 'boolean',
        'properties' => 'json'
    ];
    
    public static function newFactory()
    {
        return EmployeeFactory::new();
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

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
        return $query->where('division_id', authenticated()->employee->division_id);
    }

    public function division()
    {
        return $this->belongsTo(SYS_Division::class, 'division_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'employee_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(HR_Plantilla::class, 'position_id', 'id');
    }
}