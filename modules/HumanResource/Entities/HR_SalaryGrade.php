<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Database\factories\SalaryGradeFactory;

class HR_SalaryGrade extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'hrm_salary_grade';

    protected static function newFactory()
    {
        return SalaryGradeFactory::new();
    }

    public function plantilla()
    {
        return $this->hasMany(HR_Plantilla::class, 'salary_grade_id', 'id');
    }
}
