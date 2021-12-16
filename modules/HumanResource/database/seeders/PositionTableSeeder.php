<?php

namespace Modules\HumanResource\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\core\Models\Plantilla\Position;

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
        $file = module_path('HumanResource', 'database/data/positions.json');
        $positions = json_decode(file_get_contents($file), true);
        Position::insert($positions);
    }
}
