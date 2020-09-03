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

        // $this->call("OthersTableSeeder");
        $user = SYS_User::create([
            'employee_id' => 1,
            'username' => 'sUp3r@DMiN',
            'password' => bcrypt('@l03e1t3'),
            'status' => true
        ]);


        $user->givePermissionTo('godmode');
    }
}
