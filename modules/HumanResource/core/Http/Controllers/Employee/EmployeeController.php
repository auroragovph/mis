<?php

namespace Modules\HumanResource\core\Http\Controllers\Employee;

use Illuminate\Routing\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('hrm::employee.index');
    }
}
