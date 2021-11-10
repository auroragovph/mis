<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\FileManagement\Entities\Travel\TravelOrder;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\TravelOrder\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\TravelOrder\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Travel\Order\DT;
use Modules\FileManagement\Transformers\Forms\Travel\TravelOrderDTResource;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\System\Entities\Office\Division;

class TravelOrderController extends FormController
{
    public function __construct()
    {
        $this->model = TravelOrder::class;
        $this->doctype = config('constants.document.type.travel.order');
        $this->alias = 'travel_order';
        $this->routes = [
            'show' => 'fms.travel.order.show',
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()
                    ->json($this->_dt());
        }

        activitylog(['name' => 'fms', 'log' => 'Request travel order list']);

        return view('filemanagement::forms.travel.order.index');
    }

    public function create()
    {
        activitylog(['name' => 'fms', 'log' => 'Request travel order form']);

        $divisions = Division::with('office')->get();
        $employees = Employee::with('position')->get();

        // checking if the attached document
        session_attached_form();

        return view('filemanagement::forms.travel.order.create', [
            'divisions' => $divisions,
            'employees' => $employees,
        ]);
    }

    public function store(StoreRequest $request)
    {

        $employees = Employee::with('position')->whereIn('id', [
            ...$request->post('employees'),
            (int) $request->post('requester')])
            ->get();

        $travelers = [];

        foreach ($request->post('employees') as $traveler) {
            $details = $employees->where('id', $traveler)->first();
            $travelers[] = [
                'id' => $details->id,
                'name' => name($details->name),
                'position' => $details->position->name ?? null,
            ];
        }

        $requester = $employees->where('id', $request->post('requester'))->first();

        $signatories = [
            'requester' => [
                'id' => $requester->id,
                'name' => name($requester->name),
                'position' => $requester->position->name ?? null,
            ],
            'approval' => [
                'id' => null,
                'name' => name(config('constants.employee.head.name')),
                'position' => config('constants.employee.head.position'),
            ],
        ];

        $forms = [
            'charging_id' => $request->post('charging'),
            'destination' => $request->post('destination'),
            'departure' => Carbon::parse($request->post('departure'))->format('Y-m-d'),
            'arrival' => Carbon::parse($request->post('arrival'))->format('Y-m-d'),
            'purpose' => $request->post('purpose'),
            'instruction' => $request->post('instruction'),
            'signatories' => $signatories,
            'employees' => $travelers,
        ];

        // checked if was attached
        $attached = session()->pull('fms.document.attach');
        if ($attached !== null) {
            $forms['document_id'] = (int) $attached;
            $attach_status = true;
        }

        $to = $this->save($forms, $attach_status ?? false);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Travel Order has been encoded.',
                'route' => route('fms.travel.order.show', $to->id),
            ], 201);
        }

        return redirect(route('fms.travel.order.show', $to->id))
            ->with('alert-success', 'Purchase request has been encoded.');

    }

    public function show($id)
    {

        $rels = [
            'charging',
        ];

        $to = $this->details($id, $rels);

        if (request()->has('print')) {
            return view('filemanagement::forms.travel.order.print', [
                'to' => $to,
            ]);
        }

        return view('filemanagement::forms.travel.order.show', [
            'to' => $to,
        ]);
    }

    public function edit($id)
    {

        $to = $this->details($id);

        $divisions = Division::with('office')->get();
        $employees = Employee::with('position')->get();

        return view('filemanagement::forms.travel.order.edit', [
            'employees' => $employees,
            'divisions' => $divisions,
            'to' => $to,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $forms = [
            'number' => $request->post('number'),
            'destination' => $request->destination,
            'departure' => Carbon::parse($request->departure)->format('Y-m-d'),
            'arrival' => Carbon::parse($request->arrival)->format('Y-m-d'),
            'purpose' => $request->purpose,
            'instruction' => $request->instruction,
            'approval_id' => $request->approval,
            'charging_id' => $request->charging,
        ];

        $to = $this->patch($id, $forms);

        // inserting to lists
        TravelOrderList::where('form_id', $to->id)->delete();
        $tol = TravelOrderList::insert(collect($request->post('employees'))->map(function ($item, $key) use ($to) {
            $data['form_id'] = $to->id;
            $data['employee_id'] = $item;
            return $data;
        })->toArray());

        if (request()->ajax()) {
            return response()->json([
                'message' => "Travel order has been updated.",
                'route' => route('fms.travel.order.show', $to->id),
            ]);
        }

        return redirect(route('fms.travel.order.show', $to->id))
            ->with('alert-success', "Purchase request has been updated.");

    }

    public function _dt()
    {
        $travels = TravelOrder::get();
        $datas = DT::collection($travels);


        return [
            'heading' => ['#', 'QR Code', 'Number', 'Destination', 'Purpose', 'Departure', 'Status'],
            'data' => $datas
        ];

    }

}
