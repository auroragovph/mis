<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Database\Seeders\EmployeeTableSeeder;
use Modules\HumanResource\Database\Seeders\PlantillaTableSeeder;
use Modules\System\Database\Seeders\OfficeTableSeeder;
use Modules\HumanResource\Database\Seeders\SalaryGradeTableSeeder;
use Modules\System\Database\Seeders\PermissionRoleTableSeeder;
use Modules\System\Database\Seeders\PermissionTableSeeder;
use Modules\System\Database\Seeders\RoleTableSeeder;

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
            // PlantillaTableSeeder::class,
            // EmployeeTableSeeder::class,

            // PermissionTableSeeder::class,
            // RoleTableSeeder::class,

            // PermissionRoleTableSeeder::class,

            AccountSeeder::class
        ]);
    }
}
