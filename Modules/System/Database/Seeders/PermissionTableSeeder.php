<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;
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

        $all_permissions = array();
        $modules = Module::all();

        foreach($modules as $module){
            $path = module_path($module, 'Config/permissions.php');
            if(file_exists($path)){
                $permissions = include $path;
                $all_permissions = array_merge($all_permissions, $permissions['lists']);
            }
            
        }


        $permissions = collect($all_permissions)->map(function($permission){
            return [
                'name' => $permission,
                'guard_name' => 'web'
            ];
        });

        Permission::insert($permissions);

        

    }
}
