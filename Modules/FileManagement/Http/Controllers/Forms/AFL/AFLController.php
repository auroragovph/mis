<?php

namespace Modules\FileManagement\Http\Controllers\Forms\AFL;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;

class AFLController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $documents = FMS_Document::with('afl.employee')
                            ->where('type', 500)
                            ->where('division_id', Auth::user()->employee->division_id)
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){
                $records['data'][$i]['id'] = $document->id; 
                $records['data'][$i]['encoded'] = $document->encoded; 
                $records['data'][$i]['applicant'] = name_helper($document->afl->employee->name); 
                $records['data'][$i]['type'] = $document->afl->properties['type'];
                $records['data'][$i]['status'] = show_status($document->status);
                $records['data'][$i]['action'] = hrefroute($document->id, 'fms.afl.show');
            }
            
            return response()->json($records, 200);
        }

        $employees = HR_Employee::where('division_id', Auth::user()->employee->division_id)->get();

        return view('filemanagement::form-afl.index', compact('employees'));
    }

    public function create(Request $request)
    {
        $employee = HR_Employee::with('position.salary_grade')->findOrFail($request->post('employee'));

        // checking the employee division
        dm_abort($employee->division_id, Auth::user()->employee->division_id, 403);


        return view('filemanagement::form-afl.create', [
            'employee' => $employee,
            'type' => $request->post('type')
        ]);
    }

    public function show($id)
    {

    }
}
