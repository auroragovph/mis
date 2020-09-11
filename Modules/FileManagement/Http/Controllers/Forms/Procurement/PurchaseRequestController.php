<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;

use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequestData;
// use Auth;

class PurchaseRequestController extends Controller
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
            'purchase_request.lists',
            'purchase_request.requesting',
            'purchase_request.charging',
        )
        ->where('type', 101)
        ->where('division_id', Auth::user()->employee->division_id)
        ->get();

        return view('filemanagement::form-procurement.request.index', [
            'documents' => $documents
        ]);
    }

    public function lists()
    {
        $documents = FMS_Document::with(
                        'purchase_request.lists',
                        'purchase_request.requesting',
                        'purchase_request.charging',
                    )
                    ->where('type', 101)
                    ->where('division_id', Auth::user()->employee->division_id)
                    ->get();


        $response = array('data' => []);


        foreach($documents as $document){

         
            $response['data'][] = array(
                'id' => $document->id,
                'did' => convert_to_series($document),
                'number' => $document->purchase_request->number,
                'requesting' => name_helper($document->purchase_request->requesting),
                'charging' => office_helper($document->purchase_request->charging),
                'amount' => (string)number_format($document->purchase_request->lists->sum(function($arr){return $arr->qty * $arr->cost;}), 2),
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
        $employees = HR_Employee::where('division_id', Auth::user()->employee->division_id)->get();
        $divisions = SYS_Division::with('office')->get();



        // $employee = HR_Employee::first();
        // dd(array_key_exists('fname', $employee->name));

        return view('filemanagement::form-procurement.request.create', [
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
        // validation

        // saving
        $document = FMS_Document::create([
            'division_id' => Auth::user()->employee->division_id,
            'liaison_id' => (int)$request->liaison,
            'encoder_id' => Auth::user()->id,
            'type' => 101
        ]);


        $pr = FMS_PurchaseRequest::create([
            'document_id' => $document->id,
            'purpose' => $request->purpose,
            'charging_id' => $request->charging,
            'requesting_id' => $request->requesting
        ]);

        foreach($request->cost as $key => $item){
            if($item == null || $item == ''){continue;}
            $lists[$key]['pr_id'] = $pr->id;
            $lists[$key]['stock'] = $request['stock'][$key];
            $lists[$key]['unit'] = $request['unit'][$key];
            $lists[$key]['description'] = $request['desc'][$key];
            $lists[$key]['qty'] = $request['qty'][$key];
            $lists[$key]['cost'] = $request['cost'][$key];
        }

        FMS_PurchaseRequestData::insert($lists);

        // logging
         // logging
         FMS_DocumentLog::log($document->id, 'Create the document.');

        // notifying liaison

        // redirect with message
        return redirect(route('fms.procurement.request.show', $document->id))->with('alert-success',  'Purchase request has been created.');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        $document = FMS_Document::with(
            'attachments.employee',
            'purchase_request.charging',
            'purchase_request.requesting',
            'purchase_request.lists'
            )->findOrFail($id);


        // logging
        FMS_DocumentLog::log($document->id, 'Show the document.');

        return view('filemanagement::form-procurement.request.show', [
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
        $employees = HR_Employee::where('division_id', Auth::user()->employee->division_id)->get();
        $divisions = SYS_Division::with('office')->get();

        $document = FMS_Document::with('purchase_request.lists')->findOrFail($id);

        // check if the document is PR
        if($document->type !== 101){
            abort(404);
        }

            

        
        // setting the session
        session()->pull('FMS.document.edit', 'default');
        session()->push('FMS.document.edit', $document->id);


         // logging
         FMS_DocumentLog::log($document->id, 'Edit the document.');

        return view('filemanagement::form-procurement.request.edit', [
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
        // validation
        $eid = session('FMS.document.edit');
        if($eid[0] != $id ){abort(404);}

        // updating
        $document = FMS_Document::findOrFail($id);
        $document->liaison_id = $request->liaison;
        $document->save();

        $pr = FMS_PurchaseRequest::where('document_id', $id)->get()->first();
        $pr->requesting_id = $request->requesting;
        $pr->charging_id = $request->charging;
        $pr->purpose = $request->purpose;
        $pr->save();


        FMS_PurchaseRequestData::where('pr_id', $pr->id)->delete();

        foreach($request->cost as $key => $item){
            if($item == null || $item == ''){continue;}
            $lists[$key]['pr_id'] = $pr->id;
            $lists[$key]['stock'] = $request['stock'][$key];
            $lists[$key]['unit'] = $request['unit'][$key];
            $lists[$key]['description'] = $request['desc'][$key];
            $lists[$key]['qty'] = $request['qty'][$key];
            $lists[$key]['cost'] = $request['cost'][$key];
        }

        FMS_PurchaseRequestData::insert($lists);

        // logging
         // logging
         FMS_DocumentLog::log($document->id, 'Update the document.');

        // notifying


        // redirect with message
        return redirect(route('fms.procurement.request.show', $document->id))->with('alert-success', 'Purchase request has been updated.');

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
        $document = FMS_Document::with('liaison',
                                'encoder',
                                'division.office',
                                'purchase_request.lists',
                                'purchase_request.requesting'
                            )->where('id', $id)->where('type', 101)->get()->first();

       

        $total = $document->purchase_request->lists->sum(function($amount){ return $amount['qty'] * $amount['cost'];});

        $it = 0;
        $iy = 0;

        foreach($document->purchase_request->lists as $i => $list){

            $nl = substr_count($list, '\n');

            // count first the description of the list
            $count = strlen($list->description);

            if($nl == 0){
                // 1 row = 50 string
                $row = floor($count / 50) + 1;
            }else{
                $row = $nl;
            }

            // echo $nl;

            
            $it = $it + $row;
            // echo $row." - ".$it." - "."<br>";

            $pages[$iy][] = $list->toArray();

            // checking if $it == 30
            if($it >= 30){
                // echo 'reach '.$it.' <br>';
                $it = 0;
                $iy = $iy + 1;
            }

            // checking the last item
            if($i+1 == $document->purchase_request->lists->count()){

                // this is the last itiration
                for($it; $it <= 29; $it++){

                    $list['stock'] = '';
                    $list['unit'] = '';
                    $list['description'] = '';
                    $list['qty'] = '';
                    $list['cost'] = '';
                    $pages[$iy][] = $list;
                }


            }
        }

        // print_r(collect($pages));


        $page_count = count($pages);

        // echo json_encode($pages);
         // logging
         FMS_DocumentLog::log($document->id, 'Print the document.');


        return view('filemanagement::form-procurement.request.print',[
            'document' => $document,
            'page_count' => $page_count,
            'pages' => $pages,
            'total_cost' => $total
        ]);
    }
}
