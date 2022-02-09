<?php

namespace Modules\FileManagement\core\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use Modules\FileManagement\core\Enums\Document\Type as Doctype;
use Modules\FileManagement\core\Http\Controllers\FormController;
use Modules\FileManagement\core\Http\Requests\Procurement\PurchaseRequest\StoreRequest;
use Modules\FileManagement\core\Http\Requests\Procurement\PurchaseRequest\UpdateRequest;
use Modules\FileManagement\core\Models\Procurement\PPMP;
use Modules\FileManagement\core\Models\Procurement\PurchaseRequest;
use Modules\FileManagement\core\Services\FormService;
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
            $model = PurchaseRequest::with('series.office')->get();
            $datas = \Modules\FileManagement\core\Http\Resources\Procurement\PurchaseRequest\DT::collection($model);
            return response()->json($datas);
        }


        return view('fms::procurement.request.index');
    }

    public function create()
    {

        // dd(Doctype::PROCUREMENT_PURCHASE_REQUEST->value);

        $employees = Employee::whereIn('office_id', [
            authenticated('office_id'),
            EnumsOffice::TREASURY->value,
        ])->get();

        $heads = Office::whereIn('id', [
            config('constants.office.TREASURY'),
            authenticated('office_id'),
        ])->get()->toArray();

        $ppmps = PPMP::where('office_id', 2)->first();

        return view('fms::procurement.request.' . $this->circular . '.create', [
            'heads'     => collect($heads),
            'employees' => $employees,
            'ppmps'     => $ppmps,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $forms             = $this->data($request);
        $forms['circular'] = $this->circular;

        // checked if was attached
        $attached = $request->post('__attachment', false);
        $attached = ($attached) ? decrypt($attached) : false;

        $form = (new FormService())
                    ->type(Doctype::PROCUREMENT_PURCHASE_REQUEST->value)
                    ->store($attached);

        $forms['series_id'] = $form->series->id;

        $pr = PurchaseRequest::create($forms);
        $formable = $form->formable($pr);

        return response()->json([
            'message'  => 'Purchase request has been encoded.',
            'intended' => route('fms.procurement.request.show', $pr->id),
        ], 201);
    }

    public function show($id)
    {
        // $pr = $this->details($id);
        // if (request()->has('print')) {
        //     return $this->print($pr);
        // }

        // return view('fms::procurement.request.' . $pr->circular . '.show', [
        //     'pr' => $pr,
        // ]);

        $pr = PurchaseRequest::with('series')->findOrFail($id);
        return view('fms::procurement.request.show', compact('pr'));
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
        $forms             = $this->data($request);
        $forms['number'] = $request->post('number');

        $pr = $this->patch($id, $forms);

        return response()->json([
            'message'  => "Purchase request has been updated.",
            'intended' => route('fms.procurement.request.show', $pr->id),
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

    private function data(Request $request): array
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

        return [
            'fund'        => $request->post('fund'),
            'fpp'         => $request->post('fpp'),
            'purpose'     => $request->post('purpose'),
            'particulars' => $request->post('particulars'),
            'lists'       => $request->post('lists'),
            'signatories' => $signatories,
        ];
    }
}
