<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\System\Entities\SYS_User;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $file = storage_path('app/jsons/seeds/users.json');
        $users = json_decode(file_get_contents($file), true);


        foreach($users as $user){
            $account = SYS_User::create([

                'employee_id' => $user['employee_id'],
                'username' => $user['username'],
                'password' => password_hash($user['password'], PASSWORD_BCRYPT),
                'properties' => $user['properties']
            ]);
            $account->givePermissionTo($user['permission']);
        }
    }
}
