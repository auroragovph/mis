<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Office\SYS_Division;
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

        $offices = array();
        $divisions = array();


        foreach(config('seed-offices') as $i => $office){

            $offices[] = [
                'name' => $office['name'],
                'alias' => $office['alias'],
            ];
            $divisions[] = [
                'name' => 'MAIN',
                'alias' => 'MAIN',
                'office_id' => $i + 1
            ];
        }


        foreach(config('seed-offices') as $i => $office){

            foreach($office['divisions'] as $j => $division){

                $divisions[] = [
                    'name' => $division['name'],
                    'alias' => $division['alias'],
                    'office_id' => $i + 1
                ];
            }
        }

        SYS_Office::insert($offices);
        SYS_Division::insert($divisions);


    }
}
