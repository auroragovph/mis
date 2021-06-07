<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Employee;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Procurement\PurchaseRequest;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Request\PRStoreRequest;
use Modules\FileManagement\Transformers\Forms\Procurement\Request\RequestDTResource;

class PRController extends FormController
{
    public function __construct()
    {
        $this->model = PurchaseRequest::class;
        $this->doctype = config('constants.document.type.procurement.request');
        $this->alias = 'purchase_request';
        $this->routes = [
            'show' => 'fms.cafoa.show'
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $model = PurchaseRequest::with('document.division.office')->whereHas('document', function ($q) {
                $q->where('division_id', auth_division());
            })->get();

            $datas = RequestDTResource::collection($model);
            return response()->json(["data" => $datas]);
        }

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request purchase request list.']);

        return view('filemanagement::forms.procurement.request.index');
    }

    public function create()
    {
        $employees = Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request new purchase request form.']);

        return view('filemanagement::forms.procurement.request.create', [
            'employees' => $employees
        ]);
    }

    public function store(PRStoreRequest $request)
    {

        $forms = [
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'approving_id' => $request->post('approving'),
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'particulars' => $request->post('particulars'),
            'lists' => $request->post('lists')
        ];

        $pr = $this->save($forms);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Purchase request has been encoded.',
                'route' => route('fms.procurement.request.show', $pr->id)
            ], 201);
        }

        return redirect(route('fms.procurement.request.show', $pr->id))
            ->with('alert-success', 'Purchase request has been encoded.');
    }

    public function show($id)
    {
        $rels = [
            'document.purchase_order',
            'requesting',
            'treasury',
            'approval'
        ];

        $pr = $this->details($id, $rels);

        if (request()->has('print')) {

            return $this->print($pr);
        }

        return view('filemanagement::forms.procurement.request.show', [
            'pr' => $pr
        ]);
    }

    public function edit($id)
    {
        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        $pr = $this->details($id);

        return view('filemanagement::forms.procurement.request.edit', [
            'employees' => $employees,
            'pr' => $pr
        ]);
    }

    public function update(PRStoreRequest $request, $id)
    {
        $forms = [
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'approving_id' => $request->post('approving'),
            'number' => $request->post('number'),
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'lists' => $request->post('lists')
        ];

        $pr = $this->patch($id, $forms);

        if (request()->ajax()) {
            return response()->json([
                'message' => "Purchase request has been updated.",
                'route' => route('fms.procurement.request.show', $pr->id)
            ]);
        }

        return redirect(route('fms.procurement.request.show', $pr->id))
            ->with('alert-success', "Purchase request has been updated.");
    }

    public function print($pr)
    {
        $lists = collect($pr->lists);

        $total_amount = $lists->sum(function ($amount) {
            return $amount['quantity'] * $amount['amount'];
        });

        $pages = array();
        $consumed_row = 0;
        $pager = 0;

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

                        $blank['stock'] = '';
                        $blank['unit'] = '';
                        $blank['description'] = '&nbsp';
                        $blank['quantity'] = null;
                        $blank['amount'] = null;

                        $pages[$pager][] = $blank;
                    }
                }
            }
        }



        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request information for print of purchase request',
            'props' => [
                'model' => [
                    'id' => $pr->id,
                    'class' => PurchaseRequest::class
                ]
            ]
        ]);

        return view('filemanagement::forms.procurement.request.print', [
            'pr' => $pr,
            'pages' => $pages,
            'total_amount' => $total_amount
        ]);
    }
}
