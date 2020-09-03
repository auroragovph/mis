<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = SYS_Division::with('employees', 'office')->where('name', '!=', 'MAIN')->get();
        $offices = SYS_Office::get();

        return view('system::office.division.index',[
            'offices' => $offices,
            'divisions' => $divisions
        ]);
    }

    public function store(Request $request)
    {
        
        $division = SYS_Division::create([
            "name" => $request->name,
            "alias" => $request->alias,
            "office_id" => $request->office
        ]);


        return redirect(route('sys.office.division.index'))
                ->with('alert-success', 'Division has been created.');
    
    }
}
