<?php

namespace Modules\HumanResource\Http\Controllers\Plantilla;

use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_SalaryGrade;

class SalaryGradeController extends Controller
{
    public function index()
    {
        $sgs = HR_SalaryGrade::get();

        return view('humanresource::plantilla.sg.index', [
            "sgs" => $sgs
        ]);
    }
}
