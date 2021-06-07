<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = HR_Employee::with('division.office', 'position')->get();

        return view('system::employees.index', compact('employees'));
    }

    public function create()
    {
        return view('system::employees.create');
    }
}
