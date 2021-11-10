<?php

namespace Modules\FileManagement\Http\Controllers\Forms;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\FileManagement\Entities\AFL\Leave;
use Modules\FileManagement\Transformers\Forms\AFL\AFLDTResource;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\AFL\AFLStoreRequest;
use Modules\FileManagement\Http\Requests\Forms\AFL\StoreRequest;
use Modules\System\Entities\Employee;

class AFLController extends FormController
{

    public function __construct()
    {
        $this->model = Leave::class;
        $this->doctype = config('constants.document.type.afl');
        $this->alias = 'afl';
        $this->routes = [
            'show' => 'fms.afl.show'
        ];

    }
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = FMS_AFL::with('document', 'employee')->get();
            $datas = AFLDTResource::collection($model);

            return response()->json([
                "data" => $datas
            ]);
        }
        
        return view('filemanagement::forms.afl.index');
    }

    public function create()
    {

        $employees = HR_Employee::whereIn('division_id', [
            auth_division(),
            config('constants.office.HRMO')
        ])->get();

        // setting up the sesssion if the document is attached and checking the parameters
        session_attached_form();


        return view('filemanagement::forms.afl.create', [
            'employees' => $employees
        ]);
    }

    public function store(StoreRequest $request) : RedirectResponse
    {

        $extra = $this->form_data($request, $request->post('leave_type'));

        $forms = [
            'employee_id' => $request->post('employee'),
            'approval_id' => $request->post('approval'),
            'hr_id' => $request->post('hr'),
            'properties' => $extra['properties'],
            'inclusives' => $extra['inclusives'],
            'credits' => $extra['credits']
        ];

        $attached = session()->pull('fms.document.attach');

        if($attached !== null){
            $forms['document_id'] = (int)$attached;
            $attach_status = true;
        }

        $afl = $this->save($forms, $attach_status ?? false);

        if(request()->ajax()){

            return response()->json([
                'message' => "Leave has been encoded.",
                'route' => route('fms.afl.show', $afl->id)
            ], 201);

        }

        return redirect(route('fms.afl.show', $afl->id))
                ->with('alert-success', "Leave has been encoded.");
    }

    public function show($id)
    {
        $afl = $this->details($id, ['employee', 'hr', 'approval']);

        return view('filemanagement::forms.afl.show', [
            'afl' => $afl
        ]);
    }

    public function edit($id)
    {

        $afl = Leave::with('document')->findOrFail($id);

        $employees = Employee::whereIn('division_id', [
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
        $extra = $this->form_data($request, $type);

        $forms = [
            'approval_id' => $request->post('approval'),
            'hr_id' => $request->post('hr'),
            'properties' => $extra['properties'],
            'inclusives' => $extra['inclusives'],
            'credits' => $extra['credits']
        ];

        return $this->patch($id, $forms);
    }

    public function print($id)
    {
        return $this->show_details($id, 'filemanagement::forms.afl.print', ['employee', 'hr', 'approval']);
    }

    public function form_data($request, $type)
    {
        $properties = [
            'type' => $type,
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

        return [
            'properties' => $properties,
            'inclusives' => $inclusives->sort()->values()->all(),
            'credits' => $credits
        ];
    }
}
