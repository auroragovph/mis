<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Office\SYS_Office;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $offices = [
            ['name' => 'Provincial Government of Aurora', 'alias' => 'PGA'],
            ['name' => 'Office of the Provincial Governor', 'alias' => 'PGO'],
            ['name' => 'Office of the Provincial General Service Officer', 'alias' => 'PGSO'],
            ['name' => 'Office of the Provincial Treasurer', 'alias' => 'TREASURY'],
            ['name' => 'Office of the Provincial Budget Officer', 'alias' => 'BUDGET'],
            ['name' => 'Bids and Awards Committee', 'alias' => 'BAC'],
            ['name' => 'Office of the Provincial Accountant', 'alias' => 'ACCOUNTING'],
            ['name' => 'Office of the Provincial Administrator', 'alias' => 'PADMIN'],
            ['name' => 'Office of the Provincial Social Welfare and Development Officer', 'alias' => 'PSWDO'],
            ['name' => 'Office of the Provincial Legal Officer', 'alias' => 'LEGAL'],
            ['name' => 'Office of the Vice Governor', 'alias' => 'VGO'],
            ['name' => 'Sanguniang Panlalawigan', 'alias' => 'SP'],
            ['name' => 'Office of the Provincial Human Resource Management Officer', 'alias' => 'HRMO'],
            ['name' => 'Office of the Provincial Agriculturist', 'alias' => 'OPAG'],
            ['name' => 'Office of the Provincial Assessor', 'alias' => 'ASSESSOR'],
            ['name' => 'Office of the Provincial Cooperative Officer', 'alias' => 'PCO'],
            ['name' => 'Office of the Provincial Engineer', 'alias' => 'PEO'],
            ['name' => 'Office of the Provincial Environment and Natural Resources', 'alias' => 'ENRO'],
            ['name' => 'Office of the Provincial Equipment Pool Officer', 'alias' => 'PEPO'],
            ['name' => 'Office of the Provincial Planning and Development Coordinator', 'alias' => null],
            ['name' => 'Office of the Provincial Tourism Officer', 'alias' => 'TOURISIM'],
            ['name' => 'Office of the Provincial Veterinarian', 'alias' => 'VET'],
            ['name' => 'Office of the Provincial Employment, Sports & Culture & Arts for Youth Development Officer', 'alias' => 'PESCAYDO'],
            ['name' => 'Office of the Provincial Health Officer', 'alias' => 'PHO'],
            ['name' => 'Office of the Provincial Disaster Risk Reduction Management Officer', 'alias' => 'PDRRMO'],
            ['name' => 'National Government Unit', 'alias' => 'NGU'],
        ];


        foreach($offices as $office){
            SYS_Office::create([
                'name' => $office['name'],
                'alias' => $office['alias']
            ]);
        }
    }
}
