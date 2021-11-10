<?php

namespace Modules\HumanResource\Entities\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryGrade extends Model
{
   protected $guarded = [];
   protected $table = 'hr_salary_grade';
}
