<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'godmode']);

        $permissions = [
            ['name' => 'fms.sa.activate'],
            ['name' => 'fms.sa.attach'],
            ['name' => 'fms.sa.number'],
            ['name' => 'fms.sa.rr'],
            ['name' => 'fms.document.create'],
            ['name' => 'fms.document.edit'],
        ];


        foreach($permissions as $permission){
            Permission::create($permission);
        }
    }
}
