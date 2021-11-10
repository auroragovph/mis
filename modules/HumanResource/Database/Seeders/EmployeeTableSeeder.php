<?php

namespace Modules\HumanResource\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\Employee\Employee;

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

        $file = base_path()."/database/seeds/hrm/employees.json";
        $employees = collect(json_decode(file_get_contents($file), true));

        $lists = array();
        foreach($employees as $i => $employee){
            $lists[] = [
                'division_id' => ($employee['division_id'] == 0) ? null : $employee['division_id'],
                'position_id' => null,
                'name' => json_encode([
                    'first' => $employee['name']['first'],
                    'last' => $employee['name']['last'],
                    'middle' => $employee['name']['middle'],
                    'suffix' => $employee['name']['suffix'] ?? '',
                    'title' => $employee['name']['title'] ?? '',
                ]),
                'info' => json_encode([
                    'sex' => '',
                    'address' => '',
                    'birthday' => '',
                    'civilStatus' => '',
                    'phoneNumber' => '',
                    'image' => null
                ]),
                'employment' => json_encode([
                    'type' => '',
                    'status' => 'active',
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

        Employee::insert($lists);
    }
}
