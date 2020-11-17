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
        $file = storage_path('app/seeds/hrm/plantilla.json');
        $plantilla = json_decode(file_get_contents($file), true);
        HR_Plantilla::insert($plantilla);
    }
}
