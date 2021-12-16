<?php

namespace Modules\System\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\core\Models\Office;

class OfficeTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $offices = include module_path('System', 'database/data/office.php');
        foreach($offices as $office){
            Office::create($office);
        }
    }
}
