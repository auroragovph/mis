<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Database\Seeders\RoleTableSeeder;
use Modules\System\Database\Seeders\OfficeTableSeeder;
use Modules\System\Database\Seeders\PermissionTableSeeder;
use Modules\System\Database\Seeders\PermissionRoleTableSeeder;
use Modules\HumanResource\Database\Seeders\EmployeeTableSeeder;
use Modules\HumanResource\Database\Seeders\PositionTableSeeder;
use Modules\HumanResource\Database\Seeders\PlantillaTableSeeder;
use Modules\HumanResource\Database\Seeders\SalaryGradeTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // we will include here
        $this->call([

            // OfficeTableSeeder::class,
            // SalaryGradeTableSeeder::class,
            // PositionTableSeeder::class,
            // EmployeeTableSeeder::class,

            // PermissionTableSeeder::class,
            // RoleTableSeeder::class,

            PermissionRoleTableSeeder::class,

            AccountSeeder::class
        ]);
    }
}
