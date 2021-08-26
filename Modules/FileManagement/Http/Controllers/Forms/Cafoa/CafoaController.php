<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Cafoa;

use Illuminate\Http\Request;
use Modules\FileManagement\Entities\Cafoa\Cafoa;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Cafoa\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\Cafoa\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Cafoa\CafoaDTResource;
use Modules\HumanResource\Entities\Employee\Employee;

class CafoaController extends FormController
{
    public function __construct()
    {
        $this->model    = Cafoa::class;
        $this->doctype  = config('constants.document.type.cafoa');
        $this->alias    = 'cafoa';
        $this->circular = 2020;
        $this->routes   = [
            'show' => 'fms.cafoa.show',
        ];

    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $model = Cafoa::with('document')->whereHas('document', function ($q) {
                $q->where('division_id', auth_division());
            })->get();

            $datas = CafoaDTResource::collection($model);
            return response()->json($datas);
        }

        activitylog(['name' => 'fms', 'log' => 'Request cafoa list']);

        return view('filemanagement::forms.cafoa.index');
    }

    public function create()
    {
        $employees = Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.TREASURY'),
            config('constants.office.BUDGET'),
        ])->get();

        activitylog(['name' => 'fms', 'log' => 'Request cafoa form']);

        // checking if the attached document
        session_attached_form();

        return view('filemanagement::forms.cafoa.' . $this->circular . '.create', [
            'employees' => $employees,
        ]);
    }

    public function edit($id)
    {
        $employees = Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.TREASURY'),
            config('constants.office.BUDGET'),
        ])->get();

        $cafoa = Cafoa::with('document')->findOrFail($id);

        // activity loger
        activitylog([
            'name'  => 'fms',
            'log'   => 'Request to edit cafoa',
            'props' => [
                'model' => [
                    'id'    => $id,
                    'class' => Cafoa::class,
                ],
            ],
        ]);

        return view('filemanagement::forms.cafoa.' . $cafoa->circular . '.edit', [
            'employees' => $employees,
            'cafoa'     => $cafoa,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $signatories = $this->signatories($request);
        
        $forms = [
            'circular'    => $this->circular,
            'payee'       => $request->post('payee'),
            'lists'       => $request->post('lists'),
            'particulars' => $request->post('particulars'),
            'signatories' => $signatories,
        ];

        $attached = session()->pull('fms.document.attach');

        if ($attached !== null) {
            $forms['document_id'] = (int) $attached;
            $attach_status        = true;
        }

        $cafoa = $this->save($forms, $attach_status ?? false);

        if (request()->ajax()) {

            return response()->json([
                'message' => "CAFOA has been encoded.",
                'route'   => route('fms.cafoa.show', $cafoa->id),
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
            'treasury',
        ];

        $cafoa = $this->details((int) $id);

        return view('filemanagement::forms.cafoa.' . $cafoa->circular . '.show')
            ->with('cafoa', $cafoa);

    }

    public function update(UpdateRequest $request, $id)
    {

        $signatories = $this->signatories($request);

        $forms = [
            'number'      => $request->post('number'),
            'payee'       => $request->post('payee'),
            'lists'       => $request->post('lists'),
            'particulars' => $request->post('particulars'),
            'signatories' => $signatories,
        ];

        $cafoa = $this->patch($id, $forms);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'CAFOA has been updated.',
                'route'   => route('fms.cafoa.show', $cafoa->id),
            ], 200);
        }

        return redirect(route('fms.cafoa.show', $cafoa->id))
            ->with('alert-success', 'CAFOA has been updated.');

    }

    public function signatories($request)
    {
        $employees = Employee::with('position')->whereIn('id', [
            $request->post('requester'),
            $request->post('accountant'),
            $request->post('treasury'),
            $request->post('budget'),
        ])->get();

        $requester  = $employees->where('id', $request->post('requester'))->first();
        $accountant = $employees->where('id', $request->post('accountant'))->first();
        $treasurer  = $employees->where('id', $request->post('treasury'))->first();
        $budgeter   = $employees->where('id', $request->post('budget'))->first();

        $signatories = [

            'requester'  => [
                'id'       => $requester->id ?? null,
                'name'     => name_helper($requester->name ?? null),
                'position' => $requester->position->name ?? null,
            ],

            'accountant' => [
                'id'       => $accountant->id ?? null,
                'name'     => name_helper($accountant->name ?? null),
                'position' => $accountant->position->name ?? null,
            ],

            'treasurer'  => [
                'id'       => $treasurer->id ?? null,
                'name'     => name_helper($treasurer->name ?? null),
                'position' => $treasurer->position->name ?? null,
            ],

            'budget'     => [
                'id'       => $budgeter->id ?? null,
                'name'     => name_helper($budgeter->name ?? null),
                'position' => $budgeter->position->name ?? null,
            ],

        ];

        return $signatories;
    }
}
