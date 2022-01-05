<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HumanResource\database\seeders\EmployeeTableSeeder;
use Modules\System\database\seeders\OfficeTableSeederTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            OfficeTableSeederTableSeeder::class,
            EmployeeTableSeeder::class,
        ]);

        \Modules\FileManagement\core\Models\Procurement\Supplier::factory(100)->create();
        \Modules\System\core\Models\ACL\Account::factory(10)->create();
    }
}
