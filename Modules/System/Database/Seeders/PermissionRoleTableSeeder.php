<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
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

        $permissionNames = [
            'sys.sudo', 

            'fms.sa.activate',
            'fms.sa.attach',
            'fms.sa.number',
            'fms.sa.rr',
            'fms.document.create',
            'fms.document.edit',

            'fts.*',
            'fts.sa.*',
            'fts.sa.attach',
            'fts.sa.number',
            'fts.sa.rr',
            'fts.sa.qr',
            'fts.sa.transmittal',
            'fts.document.*',
            'fts.document.view',
            'fts.document.create',
            'fts.document.edit',
            'fts.document.print'

        ];


        $permissions = collect($permissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        $roles = [
            [
                'name' => 'ROOT',
                'permissions' => ['sys.sudo']
            ],

            [
                'name' => 'FTS - User',
                'permissions' => ['fts.sa.rr', 'fts.sa.attach', 'fts.sa.number']
            ],

            [
                'name' => 'FTS - Special User',
                'permissions' => ['fts.*']
            ],

            [
                'name' => 'FTS - Encoder User',
                'permissions' => ['fts.document.*']
            ]

        ];

        foreach($roles as $role){
            Role::create(['name' => $role['name']])->givePermissionTo($role['permissions']);
        }


    }
}
