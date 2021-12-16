<?php

namespace Modules\HumanResource\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\core\Models\Plantilla\SalaryGrade;

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
        $file = module_path('HumanResource', 'database/data/salary_grade.json');
        $sg = json_decode(file_get_contents($file), true);
        SalaryGrade::insert($sg);
    }
}
