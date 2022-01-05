<?php

namespace Modules\FileManagement\core\Http\Controllers\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\core\Models\Office;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\FileManagement\core\Enums\Document\Type as Doctype;
use Modules\FileManagement\core\Http\Controllers\FormController;
use Modules\FileManagement\core\Models\Travel\Order as TravelOrder;

class OrderController extends FormController
{
    public function __construct()
    {
        $this->model    = TravelOrder::class;
        $this->doctype  = Doctype::TRAVEL_ORDER->value;
        $this->alias    = 'travel_order';
        $this->circular = 2022;
        $this->routes   = [
            'show' => 'fms.travel.order.show',
        ];
    }

    public function index()
    {
        $tos = TravelOrder::with('series.office')->get();
        return view('fms::travel.order.index', compact('tos'));
    }

    public function create()
    {
        $employees = Employee::get();
        $offices   = Office::get();
        return view('fms::travel.order.create', compact('employees', 'offices'));
    }

    public function show($id)
    {
        $to = TravelOrder::with('series')->findOrFail($id);

        return view('fms::travel.order.show', compact('to'));
    }

    public function store(Request $request)
    {

        $forms = $this->form_data($request);

        // checked if was attached
        $attached = session()->pull('fms.document.attach');
        if ($attached !== null) {
            $forms['series_id'] = (int) $attached;
            $attach_status        = true;
        }

        $to = $this->save($forms, $attach_status ?? false);

        return response()->json([
            'title' => 'Success',
            'message' => 'Travel Order has been encoded.',
            'intended'   => route('fms.travel.order.show', $to->id),
        ], 201);
    }

    public function edit($id)
    {
        $to = TravelOrder::with('series')->findOrFail($id);
        $employees = Employee::get();
        $offices   = Office::get();

        // dd($to->signatories['requester']['id']);

        return view('fms::travel.order.edit', compact('to', 'employees', 'offices'));
    }

    public function update(Request $request, $id)
    {
        $forms = $this->form_data($request);

        $to = $this->patch($id, $forms);

        return response()->json([
            'title' => 'Success',
            'message' => 'Travel Order has been updated.',
            'intended'   => route('fms.travel.order.show', $to->id),
        ], 200);

    }

    private function form_data($request)
    {
        $employees = Employee::with('position')->whereIn('id', [
            ...$request->post('employees'),
            (int) $request->post('requester')])
            ->get();

        $travelers = [];

        foreach ($request->post('employees') as $traveler) {
            $details     = $employees->where('id', $traveler)->first();
            $travelers[] = [
                'id'       => $details->id,
                'name'     => name($details->name),
                'position' => $details->position->name ?? null,
            ];
        }

        $requester = $employees->where('id', $request->post('requester'))->first();

        $signatories = [
            'requester' => [
                'id'       => $requester->id,
                'name'     => name($requester->name),
                'position' => $requester->position->name ?? null,
            ],
            'approval'  => [
                'id'       => null,
                'name'     => name(config('constants.employee.chief_executive.name')),
                'position' => config('constants.employee.chief_executive.position'),
            ],
        ];

        return [
            'charging_id' => $request->post('charging'),
            'destination' => $request->post('destination'),
            'departure'   => $request->post('departure'),
            'arrival'     => $request->post('arrival'),
            'purpose'     => $request->post('purpose'),
            'instruction' => $request->post('instruction'),
            'signatories' => $signatories,
            'employees'   => $travelers,
        ];
    }
}
