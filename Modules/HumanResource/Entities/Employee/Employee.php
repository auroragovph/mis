<?php

namespace Modules\HumanResource\Entities\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanResource\Database\factories\EmployeeFactory;
use Modules\HumanResource\Traits\Relationship\EmployeeRelationship;

class Employee extends Model
{
    use SoftDeletes, HasFactory, EmployeeRelationship;

    protected $guarded = [];
    protected $table = 'hr_employees';

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

    public static function find_liaison($card)
    {
        $self = new static;
        $liaison =  $self->where('card', employee_id_helper($card))->where('liaison', true)->first();
        return ($liaison) ? $liaison : null;
    }
}
