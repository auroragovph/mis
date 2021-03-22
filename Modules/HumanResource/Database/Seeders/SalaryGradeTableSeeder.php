<?php

namespace Modules\HumanResource\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_SalaryGrade;

class SalaryGradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $file = base_path()."/database/seeds/hrm/salary_grade.json";
        // $file = storage_path('app/seeds/hrm/salary_grade.json');
        $sg = json_decode(file_get_contents($file), true);
        HR_SalaryGrade::insert($sg);

    }
}
