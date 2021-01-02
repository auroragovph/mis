<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Travel\FMS_TO;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TOL;
use Modules\FileManagement\Http\Requests\Forms\TravelOrder\TravelOrderStoreRequest;
use Modules\FileManagement\Transformers\Forms\Travel\TravelOrderDTResource;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;

class TravelOrderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $datas = TravelOrderDTResource::collection(FMS_TO::with('lists.employee', 'document')->get());
            return response()->json($datas);
        }

        return view('filemanagement::forms.travel.order.index');
    }

    public function create()
    {
        return view('filemanagement::forms.travel.order.create');
    }

    public function store(TravelOrderStoreRequest $request)
    {
        // storing document
        $document = FMS_Document::directStore($request->post('liaison'), 301);

        $to = FMS_TO::create([
            'document_id' => $document->id,
            'destination' => $request->destination,
            'departure' => Carbon::parse($request->departure)->format('Y-m-d'),
            'arrival' => Carbon::parse($request->arrival)->format('Y-m-d'),
            'purpose' => $request->purpose,
            'instruction' => $request->instruction,
            'approval_id' => $request->approval,
            'charging_id' => $request->charging
        ]);


        // inserting to lists
        $tol = FMS_TOL::insert(collect($request->post('employees'))->map(function($item, $key) use($to){
            $data['form_id'] = $to->id;
            $data['employee_id'] = $item;
            return $data;
        })->toArray());

        // setting session
        session()->flash('alert-success', 'Travel Order has been encoded.');

        return response()->json([
            'message' => "Travel Order has been encoded.",
            'route' => route('fms.travel.order.show', $to->id)
        ]);
        
    }

    public function show($id)
    {
        $to = FMS_TO::with('document.liaison', 'document.encoder', 'document.division.office', 'lists.employee.position')->findOrFail($id);
        return view('filemanagement::forms.travel.order.show', compact('to'));
    }

    public function edit($id)
    {
        $to = FMS_TO::with('document', 'lists')->findOrFail($id);
        $employees = HR_Employee::with('position')->onlyDivision()->get();
        $divisions = SYS_Division::with('office')->get();

        return view('filemanagement::forms.travel.order.edit', [
            'employees' => $employees,
            'divisions' => $divisions,
            'to' => $to
        ]);
    }

    public function update(TravelOrderStoreRequest $request, $id)
    {

        $to = FMS_TO::with(
                            'document.liaison',
                            'document.encoder',
                            'document.division.office',
                            'lists.employee.position')
                        ->findOrFail($id);

        $to->update([
            'number' => $request->post('number'),
            'destination' => $request->post('destination'),
            'departure' => Carbon::parse($request->post('departure'))->format('Y-m-d'),
            'arrival' => Carbon::parse($request->post('arrival'))->format('Y-m-d'),
            'purpose' => $request->post('purpose'),
            'instruction' => $request->post('instruction'),
            'approval_id' => $request->post('approval_id'),
            'charging_id' => $request->post('charging_id'),
        ]);

        // inserting to lists
        FMS_TOL::where('form_id', $to->id)->delete();
        $tol = FMS_TOL::insert(collect($request->post('employees'))->map(function($item, $key) use($to){
            $data['form_id'] = $to->id;
            $data['employee_id'] = $item;
            return $data;
        })->toArray());

        // setting session
        session()->flash('alert-success', 'Travel Order has been updated.');

        return response()->json([
            'message' => "Travel Order has been updated.",
            'route' => route('fms.travel.order.show', $to->id)
        ]);

    }

    public function print($id)
    {
        $to = FMS_TO::with(
                            'document.division.office',
                            'lists.employee.position',
                            'charging',
                            'approval.position'
                )
            ->findOrFail($id);

        return view('filemanagement::forms.travel.order.print', [
            'to' => $to
        ]);
    }
}
