<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $file = base_path()."/database/seeds/sys/accounts.json";
        $accounts = collect(json_decode(file_get_contents($file), true));

        $password = Hash::make('user123');

        foreach($accounts as $account){

            $acc = Account::create([
                'employee_id' => $account['employee_id'],
                'username' => $account['username'],
                'password' => $password,
                'status' => true,
                'properties' => $account['properties']
            ]);

            $acc->givePermissionTo($account['permission']);
        }

        

    }
}
