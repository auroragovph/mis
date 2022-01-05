<?php

namespace Modules\FileManagement\core\Http\Controllers\Procurement;

use Modules\FileManagement\core\Enums\Document\Type as Doctype;
use Modules\FileManagement\core\Http\Controllers\FormController;
use Modules\FileManagement\core\Http\Requests\Procurement\PurchaseRequest\StoreRequest;
use Modules\FileManagement\core\Http\Requests\Procurement\PurchaseRequest\UpdateRequest;
use Modules\FileManagement\core\Models\Procurement\PurchaseRequest;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\System\core\Enums\Office as EnumsOffice;
use Modules\System\core\Models\Office;

class PurchaseRequestController extends FormController
{
    public function __construct()
    {
        $this->model    = PurchaseRequest::class;
        $this->doctype  = Doctype::PROCUREMENT_PURCHASE_REQUEST->value;
        $this->alias    = 'purchase_request';
        $this->circular = 2022;
        $this->routes   = [
            'show' => 'fms.procurement.request.show',
        ];
    }

    public function index()
    {
        if (request()->ajax()) {

            // $model = PurchaseRequest::with('series')->whereHas('series', function ($q) {
            //     $q->where('office_id', authenticated('office_id'));
            // })->get();

            $model = PurchaseRequest::with('series.office')->get();

            $datas = \Modules\FileManagement\core\Http\Resources\Procurement\PurchaseRequest\DT::collection($model);

            return response()->json($datas);
        }

        return view('fms::procurement.request.index');
    }

    public function create()
    {
        $employees = Employee::whereIn('office_id', [
            authenticated('office_id'),
            EnumsOffice::TREASURY->value,
        ])->get();

        $heads = Office::whereIn('id', [
            config('constants.office.TREASURY'),
            authenticated('office_id'),
        ])->get()->toArray();

        // checking if the attached document
        // session_attached_form();

        return view('fms::procurement.request.' . $this->circular . '.create', [
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
                'name'     => name($requester->name),
                'position' => $requester->position->name ?? null,
            ],

            'treasury'   => [
                'id'       => $treasurer->id ?? null,
                'name'     => name($treasurer->name),
                'position' => $requester->treasurer->name ?? null,
            ],

            'approving'  => [
                'id'       => null,
                'name'     => name(config('constants.employee.chief_executive.name')),
                'position' => config('constants.employee.chief_executive.position'),
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
            $forms['series_id'] = (int) $attached;
            $attach_status      = true;
        }
        $pr = $this->save($forms, $attach_status ?? false);

        return response()->json([
            'message' => 'Purchase request has been encoded.',
            'intended'   => route('fms.procurement.request.show', $pr->id),
        ], 201);
    }

    public function show($id)
    {

        $pr = $this->details($id);

        if (request()->has('print')) {
            return $this->print($pr);
        }

        return view('fms::procurement.request.' . $pr->circular . '.show', [
            'pr' => $pr,
        ]);
    }

    public function edit($id)
    {
        $employees = Employee::whereIn('office_id', [
            authenticated('office_id'),
            EnumsOffice::TREASURY->value,
        ])->get();

        $pr = $this->details($id);

        return view('fms::procurement.request.' . $this->circular . '.edit', [
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
                'name'     => name($requester->name),
                'position' => $requester->position->name ?? null,
            ],

            'treasury'   => [
                'id'       => $treasurer->id ?? null,
                'name'     => name($treasurer->name),
                'position' => $requester->treasurer->name ?? null,
            ],

            'approving'  => [
                'id'       => null,
                'name'     => name(config('constants.employee.chief_executive.name')),
                'position' => config('constants.employee.chief_executive.position'),
            ],

        ];

        $forms = [
            'number'      => $request->post('number'),
            'fund'        => $request->post('fund'),
            'fpp'         => $request->post('fpp'),
            'purpose'     => $request->post('purpose'),
            'lists'       => $request->post('lists'),
            'signatories' => $signatories,
        ];

        $pr = $this->patch($id, $forms);

        return response()->json([
            'message' => "Purchase request has been updated.",
            'intended'   => route('fms.procurement.request.show', $pr->id),
        ]);
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

        return view('filemanagement::forms.procurement.request.' . $pr->circular . '.print', [
            'pr'           => $pr,
            'pages'        => $pages,
            'total_amount' => $total_amount,
        ]);
    }
}
