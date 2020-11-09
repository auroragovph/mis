<?php

namespace Modules\HumanResource\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\SYS_User;

class EmployeeTableSeeder extends Seeder
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
        // factory(\Modules\HumanResource\Entities\HR_Employee::class, 100)->create();
        $employees = collect(json_decode(file_get_contents(storage_path('app/jsons/seeds/employees.json')), true));

        
        $lists = array();
        foreach($employees as $i => $employee){
            $lists[] = [
                'division_id' => $employee['division_id'],
                'position_id' => 0,
                'name' => json_encode([
                    'fname' => $employee['name']['fname'],
                    'lname' => $employee['name']['lname'],
                    'mname' => $employee['name']['mname'],
                    'sname' => $employee['name']['suffix'] ?? '',
                    'title' => $employee['name']['title'] ?? '',
                ]),
                'info' => json_encode([
                    'gender' => '',
                    'address' => '',
                    'birthday' => '',
                    'civilStatus' => '',
                    'phoneNumber' => ''
                ]),
                'employment' => json_encode([
                    'type' => 1,
                    'status' => 1,
                    'leave' => [
                        'vacation' => 0,
                        'sick' => 0
                    ]
                ]),
                'card' => 0,
                'liaison' => $employee['liaison'],
                'properties' => json_encode($employee['properties']),
                'created_at' => now()
            ];
        }

        HR_Employee::insert($lists);
    }
}
