<?php

namespace Modules\HumanResource\Http\Controllers\Plantilla;

use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Plantilla;

class PositionController extends Controller
{
    public function index()
    {
        $positions = HR_Plantilla::with('salary_grade')->get();

        return view('humanresource::plantilla.position.index', [
            "positions" => $positions
        ]);
    }
}
