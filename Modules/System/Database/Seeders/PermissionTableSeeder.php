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

        $permissions = [

            ['name' => 'sys.sudo'],

            ['name' => 'fms.sa.activate'],
            ['name' => 'fms.sa.attach'],
            ['name' => 'fms.sa.number'],
            ['name' => 'fms.sa.rr'],
            ['name' => 'fms.document.create'],
            ['name' => 'fms.document.edit'],

            ['name' => 'fts.*'],
            ['name' => 'fts.sa.*'],
            ['name' => 'fts.sa.attach'],
            ['name' => 'fts.sa.number'],
            ['name' => 'fts.sa.rr'],
            ['name' => 'fts.sa.qr'],
            ['name' => 'fts.sa.transmittal'],
            ['name' => 'fts.document.*'],
            ['name' => 'fts.document.view'],
            ['name' => 'fts.document.create'],
            ['name' => 'fts.document.edit'],
            ['name' => 'fts.document.print'],

        ];

        // $permissions = [

        //     ['name' => 'sys.sudo', 'guard_name' => 'web'],

        //     ['name' => 'fms.sa.activate', 'guard_name' => 'web'],
        //     ['name' => 'fms.sa.attach', 'guard_name' => 'web'],
        //     ['name' => 'fms.sa.number', 'guard_name' => 'web'],
        //     ['name' => 'fms.sa.rr', 'guard_name' => 'web'],
        //     ['name' => 'fms.document.create', 'guard_name' => 'web'],
        //     ['name' => 'fms.document.edit', 'guard_name' => 'web'],

        //     ['name' => 'fts.*', 'guard_name' => 'web'],
        //     ['name' => 'fts.sa.*', 'guard_name' => 'web'],
        //     ['name' => 'fts.sa.attach', 'guard_name' => 'web'],
        //     ['name' => 'fts.sa.number', 'guard_name' => 'web'],
        //     ['name' => 'fts.sa.rr', 'guard_name' => 'web'],
        //     ['name' => 'fts.sa.qr', 'guard_name' => 'web'],
        //     ['name' => 'fts.sa.transmittal', 'guard_name' => 'web'],
        //     ['name' => 'fts.document.*', 'guard_name' => 'web'],
        //     ['name' => 'fts.document.view', 'guard_name' => 'web'],
        //     ['name' => 'fts.document.create', 'guard_name' => 'web'],
        //     ['name' => 'fts.document.edit', 'guard_name' => 'web'],
        //     ['name' => 'fts.document.print', 'guard_name' => 'web'],

        // ];


        foreach($permissions as $permission){
            Permission::create($permission);
        }

    }
}
