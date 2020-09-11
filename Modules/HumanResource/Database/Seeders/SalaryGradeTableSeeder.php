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

        $file_n = storage_path('/app/seeders_documents/sg.csv');
        $file = fopen($file_n, "r");

        $sg = array();

        $x = 0;

        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE) {
            if($x == 0){$x++;continue;}

            $sg[] = [
                'step1' => $data[0],
                'step2' => $data[1],
                'step3' => $data[2],
                'step4' => $data[3],
                'step5' => $data[4],
                'step6' => $data[5],
                'step7' => $data[6],
                'step8' => $data[7]
            ];
        }


        HR_SalaryGrade::insert($sg);
    }
}
