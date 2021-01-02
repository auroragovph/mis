<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use EmployeeFactory;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Spatie\Permission\Models\Role;

class DevController extends Controller
{
    public function index()
    {
       $doc = FMS_Document::create([
           'division_id' => 1,
           'liaison_id' => 1,
           'encoder_id' => 1,
           'status' => 1,
           'type' => 900,
       ]);
    }
}
