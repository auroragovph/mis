<?php

namespace Modules\FileManagement\Http\Controllers\Forms\AFL;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\FileManagement\Entities\Document\FMS_Document;

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
            $x = 0;
            foreach($documents as $i => $document){

                if($document->afl == null){continue;}

                $records['data'][$x]['qr'] = $document->qr; 
                $records['data'][$x]['encoded'] = $document->encoded; 
                $records['data'][$x]['applicant'] = name_helper($document->afl->employee->name); 
                $records['data'][$x]['type'] = $document->afl->properties['type'];
                $records['data'][$x]['status'] = show_status($document->status);
                $records['data'][$x]['action'] = hrefroute($document->id, 'fms.afl.show');
                $x++;
            }
            
            return response()->json($records, 200);
        }

        if(auth()->user()->can('godmode')){
            $employees = HR_Employee::get();

        }else{
            $employees = HR_Employee::where('division_id', auth()->user()->employee->division_id)->get();
        }

        return view('filemanagement::forms.afl.index', compact('employees'));
    }

    public function create(Request $request)
    {
        $employee = HR_Employee::with('position.salary_grade')->findOrFail($request->post('employee'));
        $employees = HR_Employee::whereIn('division_id', [Auth::user()->employee->division_id, 13])->get();

        // checking the employee division
        dm_abort($employee->division_id, Auth::user()->employee->division_id, 403, false);


        // setting up the sesssion
        session(['fms.document.afl.create' => ['employee' => (int)$request->post('employee'), 'type' => $request->post('type')]]);

        // dd(session()->pull('fms.document.afl.create'));

        // dd($employees->where('division_id', config('constants.office.HRMO')));

        return view('filemanagement::forms.afl.create', [
            'employee' => $employee,
            'employees' => $employees,
            'type' => $request->post('type')
        ]);
    }

    public function store(Request $request)
    {
        $details = session()->pull('fms.document.afl.create');


        $type = $details['type'];
        $employee = $details['employee'];


        $document = FMS_Document::directStore($request->liaison, 500);

        

        $properties = [
            'type' => $details['type'],
            'commutation' => boolval($request->post('commutation')),
            'approved' => [
                'with' => $request->post('days-with-pay'),
                'without' => $request->post('days-without-pay'),
            ],
        ];

        switch($type){

            case 'Vacation': 
                $details = [
                    'reason' => ($request->post('vacation1') == 'vac-tse') ? 'tse' : $request->post('vac-oth'),
                    'place' => ($request->post('vacation2') == 'vac-ph') ? 'ph' : $request->post('vac-abr')
                ];
            break; 

            case 'Sick': 
                $details = ($request->has('sick-inh')) ? $request->post('sick-spec') : null;
            break;

            default: 
                $details = ($request->has('leave-other')) ? $request->post('leave-other') : null;
            break;

        } 

        $properties['details'] = $details;
        $credits = [
            'as-of' => $request->post('caf'),
            'vacation' => [$request->post('v1'),$request->post('v2')],
            'sick' => [$request->post('s1'),$request->post('s2')]
        ];

        $signatories = [
            'hr' => $request->post('hr'),
            'approval' => $request->post('approval')
        ];

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl = FMS_AFL::create([
            'document_id' => $document->id,
            'employee_id' => $employee,
            'properties' => $properties,
            'inclusives' => $inclusives->sort()->values()->all(),
            'credits' => $credits,
            'signatories' => $signatories
        ]);

        return redirect(route('fms.afl.show', $document->id))->with('alert-success', 'Application for leave has been encoded');

    }

    public function show($id)
    {
        $document = FMS_Document::with(
            'attachments',
            'afl.employee',
            'afl.hr',
            'afl.approval'
        )->findOrFail($id);

        // dd($document);

        return view('filemanagement::forms.afl.show', compact('document'));
    }

    public function edit($id)
    {
        
        // finding the document with afl
        $document = FMS_Document::with('afl.employee')->findOrFail($id);

        // checking if the document is AFL
        // dm_abort($document->type, 500);

        $employees = HR_Employee::whereIn('division_id', [Auth::user()->employee->division_id, config('constants.office.HRMO')])->get();

        // setting up the sesssion
        session(['fms.document.afl.edit' => ['id' => (int)$id,'type' => $document->afl->properties['type']]]);

        return view('filemanagement::forms.afl.edit', [
            'document' => $document,
            'type' => $document->afl->properties['type'],
            'employee' => $document->afl->employee,
            'employees' => $employees
        ]);
    }

    public function update(Request $request, $id)
    {
        $session_keys = session()->pull('fms.document.afl.edit');

        dm_abort($id, $session_keys['id']);

        $document = FMS_Document::findOrFail($id);
        $document->liaison_id = $request->post('liaison');
        $document->save();


        $properties = [
            'type' => $session_keys['type'],
            'commutation' => boolval($request->post('commutation')),
            'approved' => [
                'with' => $request->post('days-with-pay'),
                'without' => $request->post('days-without-pay'),
            ],
        ];

        switch($session_keys['type']){

            case 'Vacation': 
                $details = [
                    'reason' => ($request->post('vacation1') == 'vac-tse') ? 'tse' : $request->post('vac-oth'),
                    'place' => ($request->post('vacation2') == 'vac-ph') ? 'ph' : $request->post('vac-abr')
                ];
            break; 

            case 'Sick': 
                $details = ($request->has('sick-inh')) ? $request->post('sick-spec') : null;
            break;

            default: 
                $details = ($request->has('leave-other')) ? $request->post('leave-other') : null;
            break;

        } 

        $properties['details'] = $details;
        $credits = [
            'as-of' => $request->post('caf'),
            'vacation' => [$request->post('v1'),$request->post('v2')],
            'sick' => [$request->post('s1'),$request->post('s2')]
        ];

        $signatories = [
            'hr' => $request->post('hr'),
            'approval' => $request->post('approval')
        ];

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }


        $afl = FMS_AFL::where('document_id', $id)->first();
        $afl->properties = $properties;
        $afl->inclusives = $inclusives->sort()->values()->all();
        $afl->credits = $credits;
        $afl->signatories = $signatories;
        $afl->save();

        return redirect(route('fms.afl.show', $document->id))->with('alert-success', 'AFL has been updated.');



        
    }

    public function print($id)
    {
        $document = FMS_Document::with(
            'attachments',
            'afl.employee',
            'afl.hr',
            'afl.approval'
        )->findOrFail($id);

        // dd($document);

        return view('filemanagement::forms.afl.print', compact('document'));
    }
}
