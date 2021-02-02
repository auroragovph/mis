<?php

namespace App\Http\Controllers;

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
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
            $tables = DB::select('SHOW TABLES');

            // dd($tables);
        foreach($tables as $table){
            Schema::drop($table->Tables_in_mis);
            echo 'Table '.$table->Tables_in_mis.' Droped. <br>';
        }
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");
    }
}
