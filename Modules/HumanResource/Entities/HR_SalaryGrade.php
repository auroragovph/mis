<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Model;

class HR_SalaryGrade extends Model
{
    protected $guarded = [];
    protected $table = 'hrm_salary_grade';

    public function plantilla()
    {
        return $this->hasMany(HR_Plantilla::class, 'salary_grade_id', 'id');
    }
}
