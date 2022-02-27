<?php

namespace Modules\HumanResource\core\Http\Controllers\Employee;

use Illuminate\Routing\Controller;
use Modules\HumanResource\core\Models\Plantilla\Position;
use Modules\System\core\Models\Office;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('hrm::employee.index');
    }

    public function create()
    {
        $offices = Office::get()->toFlatTree();
        $positions = Position::get();
        return view('hrm::employee.create', compact('offices', 'positions'));
    }
}
