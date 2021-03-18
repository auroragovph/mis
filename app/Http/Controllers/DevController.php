<?php

namespace App\Http\Controllers;

use Faker\Factory;
use EmployeeFactory;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
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

        $menus = config('filemanagement.menu');

        foreach($menus as $menu){

            if(!empty($menu['sub'])){
                $list_permissisons = collect($menu['sub'])->pluck('permissions')->flatten();

                dd($list_permissisons);
            }

        }
    
    }
}
