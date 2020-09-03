<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = SYS_Office::with('divisions.employees')->get();

        return view('system::office.index',[
            'offices' => $offices
        ]);
    }

    public function store(Request $request)
    {
        $office = SYS_Office::create([
            "name" => $request->name,
            "alias" => $request->alias,
        ]);

        $division = SYS_Division::create([
            "office_id" => $office->id
        ]);


        return redirect(route('sys.office.index'))->with('alert-success', 'Office has been created.');
    }
}
