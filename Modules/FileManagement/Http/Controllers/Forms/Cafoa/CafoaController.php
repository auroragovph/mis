<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Cafoa;

use Illuminate\Http\Request;
use Modules\System\Entities\Employee;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Cafoa\Cafoa;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Cafoa\StoreRequest;
use Modules\FileManagement\Transformers\Forms\Cafoa\CafoaDTResource;
use Modules\FileManagement\Http\Requests\Forms\Cafoa\UpdateRequest;

class CafoaController extends FormController
{
    public function __construct()
    {
        $this->model = Cafoa::class;
        $this->doctype = config('constants.document.type.cafoa');
        $this->alias = 'cafoa';
        $this->routes = [
            'show' => 'fms.cafoa.show'
        ];

    }

    public function index(Request $request)
    {

        if($request->ajax()){

            $model = Cafoa::with('document')->whereHas('document', function($q){
                $q->where('division_id', auth_division());
            })->get();

            $datas = CafoaDTResource::collection($model);
            return response()->json(["data" => $datas]);
        }

        activitylog(['name' => 'fms', 'log' => 'Request cafoa list']);

        return view('filemanagement::forms.cafoa.index');
    }

    public function create()
    {
        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        activitylog(['name' => 'fms', 'log' => 'Request cafoa form']);

        if(request()->has('attachment')){

            $doc_id = request()->get('document_id');
            $document = Document::findOrFail($doc_id);

            if($document->qr != request()->get('qrcode')){
                return abort(404);
            }

            session(['fms.document.attach.cafoa' => (int)$doc_id]);
        }


        return view('filemanagement::forms.cafoa.create', [
            'employees' => $employees
        ]);
    }

    public function edit($id)
    {
        $employees = Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        $cafoa = Cafoa::with('document')->findOrFail($id);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request to edit cafoa', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => Cafoa::class
                ]
            ]
        ]);

        return view('filemanagement::forms.cafoa.edit', [
            'employees' => $employees,
            'cafoa' => $cafoa
        ]);
    }

    public function store(StoreRequest $request)
    {
        $forms = [
            'payee' => $request->post('payee'),
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'budget_id' => $request->post('budget'),
            'accountant_id' => $request->post('accountant'),
            'requesting_id' => $request->post('requesting'),
            'lists' => $request->post('lists')
        ];

        $attached = session()->pull('fms.document.attach.cafoa');

        if($attached !== null){
            $forms['document_id'] = (int)$attached;
            $attach_status = true;
        }

            
        $cafoa = $this->save($forms, $attach_status ?? false);

        if(request()->ajax()){

            return response()->json([
                'message' => "CAFOA has been encoded.",
                'route' => route('fms.cafoa.show', $cafoa->id)
            ], 201);

        }

        return redirect(route('fms.cafoa.show', $cafoa->id))
                ->with('alert-success', "CAFOA has been encoded.");
    }

    public function show($id)
    {

        $rels = [
            'requesting',
            'budget',
            'accounting',
            'treasury'
        ];

        $cafoa = $this->details((int)$id);

        return view('filemanagement::forms.cafoa.show')
                ->with('cafoa', $cafoa);

    }

    public function update(UpdateRequest $request, $id)
    {

        $forms = [
            'payee' => $request->post('payee'),
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'budget_id' => $request->post('budget'),
            'accountant_id' => $request->post('accountant'),
            'requesting_id' => $request->post('requesting'),
            'lists' => $request->post('lists')
        ];

        $cafoa = $this->patch($id, $forms);

        if(request()->ajax()){
            return response()->json([
                'message' => 'CAFOA has been updated.',
                'route' => route('fms.cafoa.show', $cafoa->id)
            ], 200);
        }

        return redirect(route('fms.cafoa.show', $cafoa->id))
                    ->with('alert-success', 'CAFOA has been updated.');
        


    }
}
