<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            'employee_id' => 1,
            'username' => 'xijeixhan',
            'password' => bcrypt('jems7130'),
            'status' => true,
            'properties' => null
        ]);
    }
}
