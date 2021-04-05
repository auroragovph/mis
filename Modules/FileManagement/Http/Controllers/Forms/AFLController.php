<?php

namespace Modules\FileManagement\Http\Controllers\Forms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Http\Requests\Forms\AFL\AFLStoreRequest;
use Modules\FileManagement\Transformers\Forms\AFL\AFLDTResource;

class AFLController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = FMS_AFL::with('document', 'employee')->get();
            $datas = AFLDTResource::collection($model);
            return response()->json([
                "data" => $datas
            ]);
        }


        $employees = HR_Employee::onlyDivision()->get();
        return view('filemanagement::forms.afl.index', [
            'employees' => $employees
        ]);
    }

    public function create()
    {

        $employees = HR_Employee::whereIn('division_id', [
            auth_division(),
            config('constants.office.HRMO')
        ])->get();

        // setting up the sesssion

        return view('filemanagement::forms.afl.create', [
            'employees' => $employees
        ]);
    }

    public function store(AFLStoreRequest $request)
    {

        $document = FMS_Document::directStore($request->post('liaison'), config('constants.document.type.afl'));

        $properties = [
            'type' => $request->post('leave_type'),
            'commutation' => boolval($request->post('commutation')),
            'approved' => [
                'with' => $request->post('days-with-pay'),
                'without' => $request->post('days-without-pay'),
            ],
        ];

        switch($request->post('leave_type')){

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

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl = FMS_AFL::create([
            'document_id' => $document->id,
            'employee_id' => $request->post('employee'),
            'approval_id' => $request->post('approval'),
            'hr_id' => $request->post('hr'),
            'properties' => $properties,
            'inclusives' => $inclusives->sort()->values()->all(),
            'credits' => $credits
        ]);

        return redirect(route('fms.afl.show'))->with('alert-success', 'Application for leave has been encoded.');

        return response()->json([
            'message' => 'Application for leave has been encoded.',
            'route' => route('fms.afl.show', $afl->id)
        ]);
    }

    public function show($id)
    {
        $afl = FMS_AFL::with(
            'document.attachments',
            'document.encoder',
            'document.liaison',
            'document.division.office',
            'employee', 'hr', 'approval'
        )->findOrFail($id);

        return view('filemanagement::forms.afl.show', compact('afl'));
    }

    public function edit($id)
    {

        $afl = FMS_AFL::with('document')->findOrFail($id);

        $employees = HR_Employee::whereIn('division_id', [
            auth_division(),
            config('constants.office.HRMO')
        ])->get();

        // setting up the sesssion
        session(['fms.document.afl.edit' => ['employee' => $afl->employee_id, 'type' => $afl->properties['type']]]);

        return view('filemanagement::forms.afl.edit', [
            'afl' => $afl,
            'employees' => $employees
        ]);
    }

    public function update(AFLStoreRequest $request, $id)
    {
        $details = session()->pull('fms.document.afl.edit');

        $type = $details['type'];
        $employee = $details['employee'];

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

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl = FMS_AFL::with('document')->findOrFail($id);

        $afl->update([
            'approval_id' => $request->post('approval'),
            'hr_id' => $request->post('hr'),
            'properties' => $properties,
            'inclusives' => $inclusives->sort()->values()->all(),
            'credits' => $credits
        ]);

        $afl->document()->update(['liaison_id' => $request->post('liaison')]);

        return redirect(route('fms.afl.show', $afl->id))->with('alert-success', 'AFL has been updated.');

        return response()->json([
            'message' => 'Application for leave has been updated.',
            'route' => route('fms.afl.show', $afl->id)
        ]);
    }

    public function print($id)
    {
        $afl = FMS_AFL::with(
            'document.attachments',
            'document.encoder',
            'document.liaison',
            'document.division.office',
            'employee', 'hr', 'approval'
        )->findOrFail($id);

        return view('filemanagement::forms.afl.print', [
            'afl' => $afl
        ]);
    }
}
