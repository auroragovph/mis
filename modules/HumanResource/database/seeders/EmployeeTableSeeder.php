<?php

namespace Modules\HumanResource\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\core\Models\Employee\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            SalaryGradeTableSeeder::class,
            PositionTableSeeder::class,
        ]);

        Employee::factory(100)->create();
    }
}
