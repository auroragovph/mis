<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Model;

class HR_Plantilla extends Model
{
    protected $guarded = [];
    protected $table = 'hrm_plantilla';

    public function salary_grade()
    {
        return $this->belongsTo(HR_SalaryGrade::class, 'salary_grade_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(HR_Employee::class, 'position_id', 'id');
    }
}
