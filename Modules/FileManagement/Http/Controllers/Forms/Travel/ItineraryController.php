<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_Itinerary;

class ItineraryController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $documents = FMS_Document::with(
                'itinerary.employee'
                )
                ->where('type', 302)
                ->where('division_id', Auth::user()->employee->division_id)
                ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = Carbon::parse($document->created_at)->format('F d, Y h:i A');
                $records['data'][$i]['qr'] = $document->qr;

                $records['data'][$i]['number'] = $document->itinerary->number;
                $records['data'][$i]['employee'] = name_helper($document->itinerary->employee->name);
                $records['data'][$i]['date'] = Carbon::parse($document->itinerary->properties['date'])->format('F d, Y');
                $records['data'][$i]['purpose'] = $document->itinerary->properties['purpose'];
                $records['data'][$i]['amount'] = collect($document->itinerary->lists)->sum('amount');

                $records['data'][$i]['status'] = show_status($document->status);
                $records['data'][$i]['action'] = hrefroute($document->id, 'fms.travel.itinerary.show');
            }

            return response()->json($records, 200);
        }

        return view('filemanagement::form-travel.itinerary.index');
    }

    public function create()
    {
        $employees = HR_Employee::onlyDivision();

        return view('filemanagement::form-travel.itinerary.create',[
            'employees' => $employees->get(),
            'liaisons' => $employees->liaison()->get()
        ]);
    }

    public function store(Request $request)
    {
        $document = FMS_Document::directStore($request->liaison, 302);

        foreach($request->post('list-amount') as $i => $amount){
            $lists[$i]['date'] = $request['list-date'][$i];
            $lists[$i]['destination'] = $request['list-destination'][$i];
            $lists[$i]['departure'] = $request['list-departure'][$i];
            $lists[$i]['arrival'] = $request['list-arrival'][$i];
            $lists[$i]['means'] = $request['list-means'][$i];
            $lists[$i]['trans'] = $request['list-trans'][$i];
            $lists[$i]['diem'] = $request['list-diem'][$i];
            $lists[$i]['other'] = $request['list-other'][$i];
            $lists[$i]['amount'] = $request['list-amount'][$i];
        }

        $signatories = [
            'supervisor' => $request->post('supervisor'),
            'approval' => $request->post('aprroval')
        ];

        $properties = [
            'date' => $request->post('date'),
            'purpose' => $request->post('purpose')
        ];

        $itinerary = FMS_Itinerary::create([
            'document_id' => $document->id,
            'employee_id' => $request->post('employee'),
            'fund' => $request->post('fund'),
            'properties' => $properties,
            'signatories' => $signatories,
            'lists' => $lists
        ]);

        return redirect(route('fms.travel.itinerary.show', $document->id))->with('alert-success', 'Itinerary has been encoded.');
    }

    public function show($id)
    {

        $document = FMS_Document::with(
            'itinerary.employee',
            'itinerary.approval',
            'itinerary.supervisor',
            'attachments'
            )->findOrFail($id);
            
        return view('filemanagement::form-travel.itinerary.show', [
            'document' => $document
        ]);
    }

    public function edit($id)
    {
        $document = FMS_Document::with(
            'itinerary.employee',
            'itinerary.approval',
            'itinerary.supervisor',
            'attachments'
            )->findOrFail($id);

        // checking file type
        dm_abort($document->type, config('constants.document.type.TRAVEL.ITINERARY'));

        // setting up the sessions
        session(['fms.document.edit' => $id]);

        $employees = HR_Employee::onlyDivision();

        return view('filemanagement::form-travel.itinerary.edit', [
            'document' => $document,
            'itinerary' => $document->itinerary,
            'employees' => $employees->get(),
            'liaisons' => $employees->liaison()->get()
        ]);


    }

    public function update(Request $request, $id)
    {
        $eid = session()->pull('fms.document.edit');

        // validating the id
        dm_abort($id, $eid);


        $document = FMS_Document::findOrFail($id);
        $document->liaison_id = $request->post('liaison');
        $document->save();

        $itinerary = FMS_Itinerary::where('document_id', $id)->first();
        
        foreach($request->post('list-amount') as $i => $amount){
            $lists[$i]['date'] = $request['list-date'][$i];
            $lists[$i]['destination'] = $request['list-destination'][$i];
            $lists[$i]['departure'] = $request['list-departure'][$i];
            $lists[$i]['arrival'] = $request['list-arrival'][$i];
            $lists[$i]['means'] = $request['list-means'][$i];
            $lists[$i]['trans'] = $request['list-trans'][$i];
            $lists[$i]['diem'] = $request['list-diem'][$i];
            $lists[$i]['other'] = $request['list-other'][$i];
            $lists[$i]['amount'] = $request['list-amount'][$i];
        }

        $signatories = [
            'supervisor' => $request->post('supervisor'),
            'approval' => $request->post('aprroval')
        ];

        $properties = [
            'date' => $request->post('date'),
            'purpose' => $request->post('purpose')
        ];

        $itinerary->employee_id = $request->post('employee');
        $itinerary->fund = $request->post('fund');
        $itinerary->properties = $properties;
        $itinerary->signatories = $signatories;
        $itinerary->lists = $lists;
        $itinerary->save();

        return redirect(route('fms.travel.itinerary.show', $document->id))->with('alert-success', 'Itinerary has been updated.');
        // return redirect(route('fms.travel.itinerary.show'))
        
    }
}
