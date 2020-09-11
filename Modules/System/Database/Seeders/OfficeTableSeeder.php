<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Office\SYS_Office;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $file_n = storage_path('/app/seeders_documents/offices.csv');
        $file = fopen($file_n, "r");

        $offices = array();

        $x = 0;
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE) {
            if($x == 0){$x++;continue;}
            $offices[] = ['name' => $data[0], 'alias' => $data[1]];
        }

        foreach($offices as $office){
            SYS_Office::create($office);
        }
    }
}
