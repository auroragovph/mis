<?php

namespace Modules\HumanResource\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Plantilla;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $file_n = storage_path('/app/seeders_documents/positions.csv');
        $file = fopen($file_n, "r");

        $plantilla = array();

        $x = 0;
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE) {
            if($x == 0){$x++;continue;}
            $position = $data[0];
            $sg = $data[1];
            $plantilla[] = ['position' => $position, 'salary_grade_id' => (int)$sg];
        }


        HR_Plantilla::insert($plantilla);
    }
}
