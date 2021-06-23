<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Travel\FMS_TO;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TOL;
use Modules\FileManagement\Entities\Travel\TravelOrder;
use Modules\FileManagement\Entities\Travel\TravelOrderList;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\TravelOrder\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\TravelOrder\TravelOrderStoreRequest;
use Modules\FileManagement\Http\Requests\Forms\TravelOrder\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Travel\TravelOrderDTResource;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Entities\Office\SYS_Office;

class TravelOrderController extends FormController
{
    public function __construct()
    {
        $this->model = TravelOrder::class;
        $this->doctype = config('constants.document.type.travel.order');
        $this->alias = 'travel_order';
        $this->routes = [
            'show' => 'fms.travel.order.show'
        ];
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            $datas = TravelOrderDTResource::collection(TravelOrder::with('lists.employee', 'document')->get());
            return response()->json(["data" => $datas]);
        }

        activitylog(['name' => 'fms', 'log' => 'Request travel order list']);

        return view('filemanagement::forms.travel.order.index');
    }

    public function create()
    {
        activitylog(['name' => 'fms', 'log' => 'Request travel order form']);

        $divisions = SYS_Division::with('office')->get();
        $employees = Employee::with('position')->get();

        return view('filemanagement::forms.travel.order.create', [
            'divisions' => $divisions,
            'employees' => $employees
        ]);
    }

    public function store(StoreRequest $request)
    {
        $forms = [
            'destination' => $request->destination,
            'departure' => Carbon::parse($request->departure)->format('Y-m-d'),
            'arrival' => Carbon::parse($request->arrival)->format('Y-m-d'),
            'purpose' => $request->purpose,
            'instruction' => $request->instruction,
            'approval_id' => $request->approval,
            'charging_id' => $request->charging
        ];

        $to = $this->save($forms);

        // inserting to lists
        $tol = TravelOrderList::insert(collect($request->post('employees'))->map(function($item, $key) use($to){
            $data['form_id'] = $to->id;
            $data['employee_id'] = $item;
            return $data;
        })->toArray());


        if (request()->ajax()) {
            return response()->json([
                'message' => 'Travel Order has been encoded.',
                'route' =>route('fms.travel.order.show', $to->id)
            ], 201);
        }

        return redirect(route('fms.travel.order.show', $to->id))
            ->with('alert-success', 'Purchase request has been encoded.');
        
    }

    public function show($id)
    {

        $rels = [
            'lists.employee.position',
            'charging',
            'approval.position'
        ];

        $to = $this->details($id, $rels);

        if (request()->has('print')) {
            return view('filemanagement::forms.travel.order.print', [
                'to' => $to
            ]);
        }

        return view('filemanagement::forms.travel.order.show',[
            'to' => $to
        ]);
    }

    public function edit($id)
    {

        $to = $this->details($id);

        $divisions = SYS_Division::with('office')->get();
        $employees = HR_Employee::with('position')->get();

        return view('filemanagement::forms.travel.order.edit', [
            'employees' => $employees,
            'divisions' => $divisions,
            'to' => $to
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
            'charging_id' => $request->charging
        ];

        $to = $this->patch($id, $forms);

         // inserting to lists
         TravelOrderList::where('form_id', $to->id)->delete();
         $tol = TravelOrderList::insert(collect($request->post('employees'))->map(function($item, $key) use($to){
             $data['form_id'] = $to->id;
             $data['employee_id'] = $item;
             return $data;
         })->toArray());

        if (request()->ajax()) {
            return response()->json([
                'message' => "Travel order has been updated.",
                'route' => route('fms.travel.order.show', $to->id)
            ]);
        }

        return  redirect(route('fms.travel.order.show', $to->id))
            ->with('alert-success', "Purchase request has been updated.");

    }
}
