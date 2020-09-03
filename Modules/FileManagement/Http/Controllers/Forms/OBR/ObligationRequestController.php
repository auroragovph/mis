<?php

namespace Modules\FileManagement\Http\Controllers\Forms\OBR;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Obr\FMS_ObligationRequest;
use Modules\FileManagement\Entities\Obr\FMS_ObligationRequestData;

class ObligationRequestController extends Controller
{
    public function __construct()
    {
        // middlewares
        $this->middleware('fms.document.check', ['only' => ['show', 'edit', 'update', 'print']]);
        $this->middleware(['permission:fms.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:fms.edit|fms.edit.power'], ['only' => ['edit', 'update']]);
    }
    public function index()
    {
        $documents = FMS_Document::with(
            'obligation_request.lists'
            )
            ->where('type', 200)
            ->where('division_id', Auth::user()->employee->division_id)
            ->get();
        return view('filemanagement::form-obr.index', [
            'documents' => $documents
        ]);
    }

    public function lists()
    {
        $documents = FMS_Document::with(
            'obligation_request.lists'
            )
            ->where('type', 200)
            ->where('division_id', Auth::user()->employee->division_id)
            ->get();
        
        $response = array('data' => []);

        foreach($documents as $document){

            if($document->obligation_request == null){
                continue;
            }

            $response['data'][] = array(
                'id' => $document->id,
                'did' => convert_to_series($document),
                'number' => $document->obligation_request->number,
                'payee' => $document->obligation_request->payee,
                'address' => $document->obligation_request->address,
                'amount' => number_format($document->obligation_request->lists->sum('amount'), 2),
                'status' => $document->status,
                'encoded' => Carbon::parse($document->created_at)->format('F d, Y h:i A'),
                'actions' => ''

            );

        }

        return response()->json($response, 200);
    }

    public function create()
    {
        $employees = HR_Employee::get();
        $divisions = SYS_Division::with('office')->get();

        // dd($employees);
        // die;

        return view('filemanagement::form-obr.create', [
            'employees' => $employees,
            'divisions' => $divisions
        ]);
    }

    public function store(Request $request)
    {
        $document = FMS_Document::directStore($request->liaison, 200);

        $obr = FMS_ObligationRequest::create([
            'document_id' => $document->id,
            'payee' => $request->payee,
            'address' => $request->address,
            'dh_id' => $request->dh,
            'bo_id' => $request->bo
        ]);

        // DATA OBR
        $rcs = $request->rc;
        $particulars = $request->particulars;
        $fpps = $request->fpp;
        $acs = $request->ac;
        $amounts = $request->amount;

        foreach($rcs as $i => $rc){

            FMS_ObligationRequestData::create([
                'obr_id' => $obr->id,
                'responsibility_center' => $rcs[$i],
                'particulars' => $particulars[$i],
                'fpp' => $fpps[$i],
                'account_code' => $acs[$i],
                'amount' => $amounts[$i],
            ]);

        }


        

        // logging
        FMS_DocumentLog::log($document->id, 'Document has been created.');

        // notifying liaison

        // redirect with message
        return redirect(route('fms.obr.show', $document->id))->with('alert-success', 'Obligation request has been created. Please activate your document to start the process.');

    }

    public function show($id)
    {

        $document = FMS_Document::with(
                    'division.office', 
                    'liaison', 
                    'encoder',
                    'obligation_request.lists',
                    'obligation_request.dh',
                    'obligation_request.bo'
                    )
            ->where('division_id', Auth::user()->employee->division_id)
            ->findOrFail($id);


             // logging
        FMS_DocumentLog::log($document->id, 'Request information of the document the document.');


        return view('filemanagement::form-obr.show', [
            'document' => $document
        ]);


    }

    public function edit($id)
    {
        $document = FMS_Document::with(
            'division.office', 
            'liaison', 
            'encoder',
            'obligation_request.lists',
            'obligation_request.dh',
            'obligation_request.bo'
            )
            ->where('division_id', Auth::user()->employee->division_id)
            ->findOrFail($id);

        // dd($document->obligation_request);

        $employees = HR_Employee::get();
        $divisions = SYS_Division::with('office')->get();


         // logging
         FMS_DocumentLog::log($document->id, 'Request edit module of the document.');

        return view('filemanagement::form-obr.edit', [
            'document' => $document,
            'employees' => $employees,
            'divisions' => $divisions
        ]);

    }

    public function update(Request $request, $id)
    {

        $document = FMS_Document::where('division_id', Auth::user()->employee->division_id)->findOrFail($id);
        $document->liaison_id = $request->liaison;
        $document->save();


        $obr = FMS_ObligationRequest::where('document_id', $id)->first();
        $obr->payee = $request->payee;
        $obr->address = $request->address;
        $obr->dh_id = $request->dh;
        $obr->bo_id = $request->bo;
        $obr->save();


        FMS_ObligationRequestData::where('obr_id', $obr->id)->delete();


        // DATA OBR
        $rcs = $request->rc;
        $particulars = $request->particulars;
        $fpps = $request->fpp;
        $acs = $request->ac;
        $amounts = $request->amount;

        foreach($rcs as $i => $rc){

            FMS_ObligationRequestData::create([
                'obr_id' => $obr->id,
                'responsibility_center' => $rcs[$i],
                'particulars' => $particulars[$i],
                'fpp' => $fpps[$i],
                'account_code' => $acs[$i],
                'amount' => $amounts[$i],
            ]);

        }


        // logging
         // logging
         FMS_DocumentLog::log($document->id, 'Update the document.');

        // notifying liaison


        // redirect with message
        return redirect(route('fms.obr.show', $document->id))->with('alert-success', 'Obligation request has been updated.');

    }

    public function print($id)
    {
        
        $document = FMS_Document::with(
            'division.office', 
            'liaison', 
            'encoder',
            'obligation_request.lists',
            'obligation_request.dh',
            'obligation_request.bo'
            )->findOrFail($id);


            $total = $document->obligation_request->lists->sum('amount');

        $it = 0;
        $iy = 0;

        foreach($document->obligation_request->lists as $i => $list){

            $nl = substr_count($list, '\n');

            // count first the description of the list
            $count = strlen($list->particulars);

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
            if($i+1 == $document->obligation_request->lists->count()){

                // this is the last itiration
                for($it; $it <= 29; $it++){
                    $list['responsibility_center'] = '';
                    $list['particulars'] = '';
                    $list['fpp'] = '';
                    $list['account_code'] = '';
                    $list['amount'] = '';
                    $pages[$iy][] = $list;
                }


            }
        }

        // print_r(collect($pages));


        $page_count = count($pages);

        // echo json_encode($pages);

         // logging
         FMS_DocumentLog::log($document->id, 'Print the document.');


        return view('filemanagement::form-obr.print',[
            'document' => $document,
            'page_count' => $page_count,
            'pages' => $pages,
            'total_cost' => $total
        ]);

       
    }
}
