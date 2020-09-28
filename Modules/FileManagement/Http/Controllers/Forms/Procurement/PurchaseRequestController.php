<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;

use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;
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
    public function index(Request $request)
    {
        if($request->ajax()){
            $documents = FMS_Document::with(
                'purchase_request.requesting',
            )
            ->where('type', 101)
            ->where('division_id', Auth::user()->employee->division_id)
            ->get();

            $records['data'] = array();
            
            foreach($documents as $i => $document){
                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = Carbon::parse($document->created_at)->format('F d, Y h:i A');
                $records['data'][$i]['qr'] = $document->qr;
                $records['data'][$i]['number'] = $document->purchase_request->number;
                $records['data'][$i]['requesting'] = name_helper($document->purchase_request->requesting->name);
                $records['data'][$i]['fund'] = $document->purchase_request->fund;
                $records['data'][$i]['fpp'] = $document->purchase_request->fpp;
                $records['data'][$i]['amount'] = number_format($document->purchase_request->lists->sum(function($arr){return $arr['qty'] * $arr['cost'];}), 2);
                $records['data'][$i]['status'] = show_status($document->status);
                $records['data'][$i]['action'] = hrefroute($document->id, 'fms.procurement.request.show');
            }

            return response()->json($records, 200);
        }

        return view('filemanagement::form-procurement.request.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $employees = HR_Employee::get();

        $signatories['divisions'] = $employees->where('division_id', Auth::user()->employee->division_id);
        $signatories['treasury'] = $employees->where('division_id', 4);

        $liaisons = $employees->where('division_id', Auth::user()->employee->division_id)
                                ->where('liaison', true);
                            


        return view('filemanagement::form-procurement.request.create', [
            'employees' => $employees,
            'signatories' => $signatories,
            'liaisons' => $liaisons
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
        $document = FMS_Document::directStore((int)$request->post('liaison'), 101);

        foreach($request->cost as $key => $item){
            if($item == null || $item == ''){continue;}
            $lists[$key]['stock'] = $request['stock'][$key];
            $lists[$key]['unit'] = $request['unit'][$key];
            $lists[$key]['description'] = $request['desc'][$key];
            $lists[$key]['qty'] = $request['qty'][$key];
            $lists[$key]['cost'] = $request['cost'][$key];
        }

        $signatories = [
            'requesting' => $request->post('requesting'),
            'treasury' => $request->post('treasury'),
            'approval' => $request->post('approval')
        ];

        $pr = FMS_PurchaseRequest::create([
            'document_id' => $document->id,
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'signatories' => $signatories,
            'lists' => $lists
        ]);

        
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
            'purchase_request.requesting',
            'purchase_request.treasury',
            'purchase_request.approval',
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
        $employees = HR_Employee::get();

        $signatories['divisions'] = $employees->where('division_id', Auth::user()->employee->division_id);
        $signatories['treasury'] = $employees->where('division_id', 4);

        $liaisons = $employees->where('division_id', Auth::user()->employee->division_id)
                                ->where('liaison', true);


        $document = FMS_Document::with('purchase_request')->findOrFail($id);

        // check if the document is PR
        dm_abort($document->type, 101);
        
        // setting the session
        session(['fms.document.edit' => $document->id]);


         // logging
         FMS_DocumentLog::log($document->id, 'Edit the document.');

        return view('filemanagement::form-procurement.request.edit', [
            'document' => $document,
            'employees' => $employees,
            'signatories' => $signatories,
            'liaisons' => $liaisons
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
        $eid = session()->pull('fms.document.edit');
        dm_abort($eid, $id);

        // updating
        $document = FMS_Document::findOrFail($id);
        $document->liaison_id = $request->liaison;
        $document->save();


        foreach($request->cost as $key => $item){
            if($item == null || $item == ''){continue;}
            $lists[$key]['stock'] = $request['stock'][$key];
            $lists[$key]['unit'] = $request['unit'][$key];
            $lists[$key]['description'] = $request['desc'][$key];
            $lists[$key]['qty'] = $request['qty'][$key];
            $lists[$key]['cost'] = $request['cost'][$key];
        }

        $signatories = [
            'requesting' => $request->post('requesting'),
            'treasury' => $request->post('treasury'),
            'approval' => $request->post('approval')
        ];

        $pr = FMS_PurchaseRequest::where('document_id', $id)->first();
        $pr->fund = $request->post('fund');
        $pr->fpp = $request->post('fpp');
        $pr->purpose = $request->post('purpose');
        $pr->signatories = $signatories;
        $pr->lists = $lists;
        $pr->save();


         // logging
         FMS_DocumentLog::log($document->id, 'Update the document.');

        // notifying


        // redirect with message
        return redirect(route('fms.procurement.request.show', $document->id))
                    ->with('alert-success', 'Purchase request has been updated.');

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
