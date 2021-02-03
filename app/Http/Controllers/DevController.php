<?php

namespace App\Http\Controllers;

use Faker\Factory;
use EmployeeFactory;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;

class DevController extends Controller
{
    public function index()
    {
        $lists = array();
        $limit = 100;

        $faker = Factory::create();

        for($start = 0; $start <= $limit; $start++){

            $lists[$start] = array(
                'stock' => '',
                'unit' => $faker->randomElement(['cm', 'set', 'kg', 'm']),
                'quantity' => $faker->numberBetween(5, 100),
                'amount' => $faker->numberBetween(100, 1000),
                'description' => $faker->randomElement([
                    $faker->sentence(),
                    $faker->word(),
                    "1 pc\r\n1 mouse\r\n1 keyboard "
                ]),

            );
        }

        echo json_encode($lists);

    }
}
