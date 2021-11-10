<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $roles = [
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
            $role = Role::create(['name' => $role['name']]);
            $role->givePermissionTo($role['permissions']);
        }



    }
}
