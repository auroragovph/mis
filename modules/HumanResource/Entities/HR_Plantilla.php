<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Database\factories\PositionFactory;

class HR_Plantilla extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'hrm_plantilla';

    protected static function newFactory()
    {
        return PositionFactory::new();
    }

    public function salary_grade()
    {
        return $this->belongsTo(HR_SalaryGrade::class, 'salary_grade_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(HR_Employee::class, 'position_id', 'id');
    }
}
