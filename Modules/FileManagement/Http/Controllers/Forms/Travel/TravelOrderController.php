<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;

class TravelOrderController extends Controller
{
    public function __construct()
    {
        // middlewares
        $this->middleware('fms.document.check', ['only' => ['show', 'edit', 'update', 'print']]);
        $this->middleware(['permission:fms.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:fms.edit|fms.edit.power'], ['only' => ['edit', 'update']]);


    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $documents = FMS_Document::with(
                'travel_order.employees'
                )
                ->where('type', 301)
                ->where('division_id', Auth::user()->employee->division_id)
                ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){
                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = Carbon::parse($document->created_at)->format('F d, Y h:i A');
                $records['data'][$i]['qr'] = $document->qr;
                $records['data'][$i]['number'] = $document->travel_order->number;
                $records['data'][$i]['employees'] = tonh($document->travel_order->employees);
                $records['data'][$i]['destination'] = $document->travel_order->destination;
                $records['data'][$i]['departure'] = $document->travel_order->departure;
                $records['data'][$i]['status'] = show_status($document->status);
                $records['data'][$i]['action'] = hrefroute($document->id, 'fms.travel.order.show');
            }

            return response()->json($records, 200);
        }
       

        // Activity logging
        activity()->log('Show the travel order');

        return view('filemanagement::form-travel.order.index');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $employees = HR_Employee::onlyDivision()->get();
        $divisions = SYS_Division::with('office')->get();


        // Activity logging
        activity()->log('Request to create a new travel order.');


        // dd(Auth::user()->division_id);


        return view('filemanagement::form-travel.order.create', [
            'employees' => $employees,
            'divisions' => $divisions
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $document = FMS_Document::directStore($request->liaison, 301);


        $to = FMS_TravelOrder::create([
            'document_id' => $document->id,
            'destination' => $request->destination,
            'departure' => Carbon::parse($request->departure)->format('Y-m-d'),
            'arrival' => Carbon::parse($request->arrival)->format('Y-m-d'),
            'purpose' => $request->purpose,
            'instruction' => $request->instruction,
            'approval_id' => $request->approval,
            'charging_id' => $request->charging,
            'lists' => $request->employees
        ]);

        // logging
        FMS_DocumentLog::log($document->id, 'Show the document.');
        activity()->withProperties([
             'id' => $document->id, 
             'type' => 301
        ])->log('Create new travel order');

        return redirect(route('fms.travel.order.show', $document->id))->with('alert-success', 'Travel order has been created.');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $document = FMS_Document::with('travel_order.employees')->findOrFail($id);

        // checking if the match type
        dm_abort($document->type, 301);

        // logging
        FMS_DocumentLog::log($document->id, 'Show the document.');
        activity()->log('Show the document.');
        

        return view('filemanagement::form-travel.order.show', [
            'document' => $document
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $document = FMS_Document::with('travel_order.employees')->findOrFail($id);


        // checking if the document match the type
        dm_abort($document->type, 301);
        

        $employees = HR_Employee::get();
        $divisions = SYS_Division::with('office')->get();

         // logging
         FMS_DocumentLog::log($document->id, 'Edit the document.');

        //  setting up the session
        session(['fms.document.edit' => $id]);


        return view('filemanagement::form-travel.order.edit', [
            'document' => $document,
            'employees' => $employees,
            'divisions' => $divisions
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $eid = session()->pull('fms.document.edit');

        // validating the id
        dm_abort($id, $eid);

        $document = FMS_Document::findOrFail($id);
        $document->liaison_id = $request->liaison;
        $document->save();

        $to = FMS_TravelOrder::where('document_id', $id)->first();
        $to->destination = $request->destination;
        $to->purpose = $request->purpose;
        $to->instruction = $request->instruction;
        $to->approval_id = $request->approval;
        $to->charging_id = $request->charging;
        $to->departure = Carbon::parse($request->departure)->format('Y-m-d');
        $to->arrival = Carbon::parse($request->arrival)->format('Y-m-d');
        $to->lists = $request->post('employees');
        $to->save();
       
        // logging
        FMS_DocumentLog::log($document->id, 'Update the document.');
        return redirect(route('fms.travel.order.show', $document->id))->with('alert-success', 'Travel order has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function print($id)
    {
        $document = FMS_Document::with('travel_order')->findOrFail($id);

        // logging
        FMS_DocumentLog::log($document->id, 'Print the document.');

        return view("filemanagement::form-travel.order.print", [
            "document" => $document
        ]);
    }
}
