<?php

namespace App\Http\Controllers;

use PDF;
use Faker\Factory;
use Illuminate\Http\Request;
use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Support\Facades\Crypt;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\FileManagement\core\Models\Procurement\PPMP;
use Modules\FileManagement\core\Models\Procurement\PurchaseRequest;

class DevController extends Controller
{
    public function __invoke(Request $request)
    {
        dd($this->eloq());
    }

    public function eloq()
    {

    }

    public function ppmp($request)
    {
        $data = [];

        $faker = Factory::create();
        $faker->addProvider(new Commerce($faker));

        for($i = 0; $i <=100; $i++){

            $data[] = [
                'description' => $faker->productName(),
                'unit' => 'pcs',
                'unit_cost' => $faker->randomFloat(2, 1, 1000),
                'schedule' => [
                    'JAN' => $faker->numberBetween(0, 100),
                    'FEB' => $faker->numberBetween(0, 100),
                    'MAR' => $faker->numberBetween(0, 100),
                    'APR' => $faker->numberBetween(0, 100),
                    'MAY' => $faker->numberBetween(0, 100),
                    'JUN' => $faker->numberBetween(0, 100),
                    'JUL' => $faker->numberBetween(0, 100),
                    'AUG' => $faker->numberBetween(0, 100),
                    'SEP' => $faker->numberBetween(0, 100),
                    'OCT' => $faker->numberBetween(0, 100),
                    'NOV' => $faker->numberBetween(0, 100),
                    'DEC' => $faker->numberBetween(0, 100)
                ]
            ];
        }
        // dd($data);

        PPMP::create([
            'office_id' => 2,
            'fiscal_year' => 2022,
            'description' => 'Office Supplies',
            'children' => $data
        ]);
    }
}
