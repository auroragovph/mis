<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Travel;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrderData;

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
    public function index()
    {
        $documents = FMS_Document::with(
            'travel_order.employees.employee'
            )
            ->where('type', 301)
            ->where('division_id', Auth::user()->employee->division_id)
            ->get();

        return view('filemanagement::form-travel.order.index', [
            'documents' => $documents
        ]);
    }

    public function lists()
    {
        $documents = FMS_Document::with(
            'travel_order.employees.employee'
            )
            ->where('type', 301)
            ->where('division_id', Auth::user()->employee->division_id)
            ->get();
        
        $response = array('data' => []);

        foreach($documents as $document){

            if($document->travel_order == null){
                continue;
            }

            if($document->travel_order->employees->count() <= 1){
                $employees = name_helper($document->travel_order->employees[0]['employee']);
            }else{
                $employees = name_helper($document->travel_order->employees[0]['employee'])." et al. ";
            }

            $response['data'][] = array(
                'id' => $document->id,
                'did' => convert_to_series($document),
                'number' => $document->travel_order->number,
                'employees' => $employees,
                'destination' => $document->travel_order->destination,
                'departure' => Carbon::parse($document->travel_order->departure)->format('F d, Y'),
                'arrival' => Carbon::parse($document->travel_order->arrival)->format('F d, Y'),
                'purpose' => $document->travel_order->purpose,
                'status' => $document->status,
                'encoded' => Carbon::parse($document->created_at)->format('F d, Y h:i A'),
                'actions' => ''

            );

        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $employees = HR_Employee::get();
        $divisions = SYS_Division::with('office')->get();

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
            'charging_id' => $request->charging
        ]);

        foreach($request->employees as $employee){
            FMS_TravelOrderData::create([
                'travel_id' => $to->id,
                'employee_id' => $employee
            ]);
        }


         // logging
         FMS_DocumentLog::log($document->id, 'Create the document.');

        return redirect(route('fms.travel.order.show', $document->id))->with('alert-success', 'Travel order has been created.');


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $document = FMS_Document::findOrFail($id);

        // dd($document->travel_order->employees68);

         // logging
         FMS_DocumentLog::log($document->id, 'Show the document.');

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
        $employees = HR_Employee::get();
        $divisions = SYS_Division::with('office')->get();
        $document = FMS_Document::with('travel_order.employees.employee')->findOrFail($id);

         // logging
         FMS_DocumentLog::log($document->id, 'Edit the document.');

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
        $to->save();


        FMS_TravelOrderData::where('travel_id', $to->id)->delete();
        foreach($request->employees as $employee){
            FMS_TravelOrderData::create([
                'travel_id' => $to->id,
                'employee_id' => $employee
            ]);
        }

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
