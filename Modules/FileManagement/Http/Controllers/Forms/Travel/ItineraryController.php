<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_IOT;
use Modules\FileManagement\Http\Requests\Forms\Travels\Itinerary\ItineraryStoreRequest;
use Modules\FileManagement\Transformers\Forms\Travel\Itinerary\ItineraryDTResource;

class ItineraryController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = FMS_IOT::with('document', 'employee')->get();
            $datas = ItineraryDTResource::collection($model);
            return response()->json($datas);
        }

        activitylog(['name' => 'fms', 'log' => 'Request itinerary of travel list']);

        return view('filemanagement::forms.travel.itinerary.index');
    }

    public function create()
    {
        $employees = HR_Employee::where('division_id', auth_division())->get();

        activitylog(['name' => 'fms', 'log' => 'Request itinerary of travel form']);

        return view('filemanagement::forms.travel.itinerary.create', [
            'employees' => $employees
        ]);
    }

    public function store(ItineraryStoreRequest $request)
    {
        // storing document
        $document = FMS_Document::directStore($request->post('liaison'), config('constants.document.type.travel.itinerary'));

        $iot = FMS_IOT::create([
            'document_id' => $document->id,
            'employee_id' => $request->post('employee'),
            'fund' => $request->post('fund'),
            'travel_date' => $request->post('travel-date'),
            'travel_purpose' => $request->post('purpose'),
            'supervisor_id' => $request->post('supervisor'),
            'head_id' => $request->post('approving'),
            'lists' => $request->post('lists')
        ]);

        // setting session
        session()->flash('alert-success', 'Itinerary of travel has been encoded.');

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Encode cafoa', 
            'props' => [
                'model' => [
                    'id' => $iot->id,
                    'class' => FMS_IOT::class
                ]
            ]
        ]);

        return response()->json([
            'message' => "Itinerary of travel has been encoded.",
            'route' => route('fms.travel.itinerary.show', $iot->id)
        ]);


    }

    public function show($id)
    {
        $iot = FMS_IOT::with(

            'document.attachments',
            'document.liaison',
            'document.encoder',
            'document.division.office',

            'employee.position',
            'head',
            'supervisor'

        )->findOrFail($id);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request information of Iitnerary of Travel', 
            'props' => [
                'model' => [
                    'id' => $iot->id,
                    'class' => FMS_IOT::class
                ]
            ]
        ]);

        return view('filemanagement::forms.travel.itinerary.show', [
            'iot' => $iot
        ]);

        
    }

    public function edit($id)
    {
        $iot = FMS_IOT::with('document')->findOrFail($id);
        $employees = HR_Employee::where('division_id', auth_division())->get();

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request to edit itinerary of travel', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_IOT::class
                ]
            ]
        ]);

        return view('filemanagement::forms.travel.itinerary.edit', [
            'iot' => $iot,
            'employees' => $employees
        ]);
    }

    public function update(ItineraryStoreRequest $request, $id)
    {
        $iot = FMS_IOT::with('document')->findOrFail($id);

        $iot->update([
            'employee_id' => $request->post('employee'),
            'fund' => $request->post('fund'),
            'travel_date' => $request->post('travel-date'),
            'travel_purpose' => $request->post('purpose'),
            'supervisor_id' => $request->post('supervisor'),
            'head_id' => $request->post('approving'),
            'lists' => $request->post('lists')
        ]);

        $iot->document()->update(['liaison_id' => $request->post('liaison')]);

        // setting session
        session()->flash('alert-success', 'Itinerary of travel has been updated.');

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Update itinerary of travel information', 
            'props' => [
                'model' => [
                    'id' => $iot->id,
                    'class' => FMS_Cafoa::class
                ]
            ]
        ]);

        return response()->json([
            'message' => "Itinerary of travel has been updated.",
            'route' => route('fms.travel.itinerary.show', $iot->id)
        ]);

    }
}
