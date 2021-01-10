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
      dd(show_status(1));
    }
}
