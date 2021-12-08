<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Modules\System\Entities\Office\Office;
use Modules\FileManagement\Enum\DocumentType;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Procurement\PurchaseRequest;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Request\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Request\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Procurement\Request\RequestDTResource;

class PRController extends FormController
{
    public function __construct()
    {
        $this->model    = PurchaseRequest::class;
        $this->doctype  = DocumentType::PROCUREMENT_PURCHASE_REQUEST->value;
        $this->alias    = 'purchase_request';
        $this->circular = 2020;
        $this->routes   = [
            'show' => 'fms.procurement.request.show',
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $model = PurchaseRequest::with('document.division.office')->whereHas('document', function ($q) {
                $q->where('division_id', auth_division());
            })->get();

            $datas = RequestDTResource::collection($model);

            return response()->json($datas);
        }

        return view('filemanagement::forms.procurement.request.index');
    }

    public function create()
    {
        $employees = Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.TREASURY'),
        ])->get();

        $heads = Office::whereIn('id', [
            config('constants.office.TREASURY'),
            authenticated()->employee->division_id
        ])->get(['id', 'head_id'])->toArray();

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request new purchase request form.']);

        // checking if the attached document
        session_attached_form();

        return view('filemanagement::forms.procurement.request.' . $this->circular . '.create', [
            'heads'     => collect($heads),
            'employees' => $employees,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $employees = Employee::with('position')->whereIn('id', [
            $request->post('requesting'),
            $request->post('treasury'),
        ])->get();

        $requester = $employees->where('id', $request->post('requesting'))->first();
        $treasurer = $employees->where('id', $request->post('treasury'))->first();

        $signatories = [

            'requesting' => [
                'id'       => $requester->id ?? null,
                'name'     => name_helper($requester->name ?? []),
                'position' => $requester->position->name ?? null
            ],

            'treasury'   => [
                'id'       => $treasurer->id ?? null,
                'name'     => name_helper($treasurer->name ?? []),
                'position' => $requester->treasurer->name ?? null
            ],

            'approving'  => [
                'id'       => null,
                'name'     => name_helper(config('constants.employee.head.name')),
                'position' => config('constants.employee.head.position'),
            ],

        ];

        $forms = [
            'circular'    => $this->circular,
            'fund'        => $request->post('fund'),
            'fpp'         => $request->post('fpp'),
            'purpose'     => $request->post('purpose'),
            'particulars' => $request->post('particulars'),
            'lists'       => $request->post('lists'),
            'signatories' => $signatories,
        ];

        // checked if was attached
        $attached = session()->pull('fms.document.attach');
        if ($attached !== null) {
            $forms['document_id'] = (int) $attached;
            $attach_status        = true;
        }
        $pr = $this->save($forms, $attach_status ?? false);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Purchase request has been encoded.',
                'route'   => route('fms.procurement.request.show', $pr->id),
            ], 201);
        }

        return redirect(route('fms.procurement.request.show', $pr->id))
            ->with('alert-success', 'Purchase request has been encoded.');
    }

    public function show($id)
    {

        $pr = $this->details($id);

        if (request()->has('print')) {
            return $this->print($pr);
        }

        return view('filemanagement::forms.procurement.request.' . $pr->circular . '.show', [
            'pr' => $pr,
        ]);
    }

    public function edit($id)
    {
        $employees = Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.TREASURY'),
        ])->get();

        $pr = $this->details($id);

        return view('filemanagement::forms.procurement.request.'.$this->circular.'.edit', [
            'employees' => $employees,
            'pr'        => $pr,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $employees = Employee::with('position')->whereIn('id', [
            $request->post('requesting'),
            $request->post('treasury'),
        ])->get();

        $requester = $employees->where('id', $request->post('requesting'))->first();
        $treasurer = $employees->where('id', $request->post('treasury'))->first();

        $signatories = [

            'requesting' => [
                'id'       => $requester->id ?? null,
                'name'     => name_helper($requester->name ?? []),
                'position' => $requester->position->name ?? null
            ],

            'treasury'   => [
                'id'       => $treasurer->id ?? null,
                'name'     => name_helper($treasurer->name ?? []),
                'position' => $requester->treasurer->name ?? null
            ],

            'approving'  => [
                'id'       => null,
                'name'     => name_helper(config('constants.employee.head')),
                'position' => config('constants.employee.head.position'),
            ],

        ];

        $forms = [
            'circular'    => $this->circular,
            'fund'        => $request->post('fund'),
            'fpp'         => $request->post('fpp'),
            'purpose'     => $request->post('purpose'),
            'particulars' => $request->post('particulars'),
            'lists'       => $request->post('lists'),
            'signatories' => $signatories,
        ];


        $forms = [
            'number'        => $request->post('number'),
            'fund'          => $request->post('fund'),
            'fpp'           => $request->post('fpp'),
            'purpose'       => $request->post('purpose'),
            'lists'         => $request->post('lists'),
            'signatories'         => $signatories,

        ];

        $pr = $this->patch($id, $forms);

        if (request()->ajax()) {
            return response()->json([
                'message' => "Purchase request has been updated.",
                'route'   => route('fms.procurement.request.show', $pr->id),
            ]);
        }

        return redirect(route('fms.procurement.request.show', $pr->id))
            ->with('alert-success', "Purchase request has been updated.");
    }

    function print($pr) {

        $lists = collect($pr->lists);

        $total_amount = $lists->sum(function ($amount) {
            return $amount['quantity'] * $amount['amount'];
        });

        $pages        = array();
        $consumed_row = 0;
        $pager        = 0;

        foreach ($lists as $index => $list) {

            $new_line = substr_count($list['description'], "\r\n");

            // count first the description of the list
            $count = strlen($list['description']);

            $list_consumed = ($new_line == 0) ? ceil($count / 40) : $new_line + 1;

            $consumed_row += $list_consumed;

            $list['consumed_row'] = $list_consumed;

            if ($consumed_row >= 30) {
                $consumed_row = 0;
                $pager++;
            } else {

                $pages[$pager][] = $list;

                if ($index + 1 == $lists->count()) {
                    // this is the last iteration
                    for ($consumed_row; $consumed_row <= 29; $consumed_row++) {

                        $blank['stock']       = '';
                        $blank['unit']        = '';
                        $blank['description'] = '&nbsp;';
                        $blank['quantity']    = null;
                        $blank['amount']      = null;

                        $pages[$pager][] = $blank;
                    }
                }
            }
        }

        // activity loger
        activitylog([
            'name'  => 'fms',
            'log'   => 'Request information for print of purchase request',
            'props' => [
                'model' => [
                    'id'    => $pr->id,
                    'class' => PurchaseRequest::class,
                ],
            ],
        ]);

        return view('filemanagement::forms.procurement.request.'.$pr->circular.'.print', [
            'pr'           => $pr,
            'pages'        => $pages,
            'total_amount' => $total_amount,
        ]);
    }
}
