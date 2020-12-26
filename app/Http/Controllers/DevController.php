<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use EmployeeFactory;

class DevController extends Controller
{
    public function index()
    {
        dd(\Modules\HumanResource\Entities\HR_Employee::newFactory());
    }
}
