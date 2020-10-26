<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $divisions = SYS_Division::with('office')->get();
        $qrs = FTS_Qr::where('status', false)->get();


        if($request->ajax()){

            $documents = FTS_Document::with('purchase_request', 'division')->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['number'] = $document->purchase_request->number;
                $records['data'][$i]['date'] = $document->purchase_request->date;
                $records['data'][$i]['particular'] = $document->purchase_request->particular;
                $records['data'][$i]['purpose'] = $document->purchase_request->purpose;
                $records['data'][$i]['charging'] = $document->purchase_request->charging;
                $records['data'][$i]['accountable'] = $document->purchase_request->accountable;
                $records['data'][$i]['amount'] = $document->purchase_request->amount;
                $records['data'][$i]['status'] = show_status($document->status);

                $action = '';

                if(Auth::user()->can('fts.document.edit')){
                    $action .= "<a href=\"#\" class=\"btn btn-xs bg-gradient-warning\"> Edit</a> ";
                }

                if(Auth::user()->can('fts.document.print')){
                    $action .= "<a target=\"_blank\" href=\"".route('fts.documents.receipt', ['series' => $document->series, 'print' => 'true'])."\" class=\"btn btn-xs bg-gradient-navy\"> Print</a>";
                }


                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);


        }


        return view('filetracking::forms.procurement.request.index',[
            'divisions' => $divisions,
            'qrs' => $qrs
        ]);
    }

    public function store(Request $request)
    {
        $series = $request->post('series');

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){
            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => 101
        ]);

        $pr = FTS_PurchaseRequest::create([
            'document_id' => $document->id, 
            'number' => $request->post('number'), 
            'date' => $request->post('date'), 
            'particular' => $request->post('particulars'), 
            'purpose' => $request->post('purpose'), 
            'charging' => $request->post('charging'), 
            'accountable' => $request->post('accountable'), 
            'amount' => $request->post('amount')
        ]);


        // changing QR status
        $qr = FTS_Qr::find($series);
        $qr->status = true;
        $qr->save();


        // INSERTING INTO TRACKING LOGS
        FTS_Tracking::create([
            'document_id' => $document->id,
            'division_id' => Auth::user()->employee->division_id,
            'user_id' => Auth::user()->employee_id,
            'liaison_id' => $liaison,
            'action' => 0,
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(Auth::user()->employee->name)),
            'status' => 2
        ]);


        $result = FTS_Document::with('division', 'purchase_request')->find($document->id);


        $action = '';

        if(Auth::user()->can('fts.document.edit')){
            $action .= "<a href=\"#\" class=\"btn btn-xs bg-gradient-warning\"> Edit</a> ";
        }

        if(Auth::user()->can('fts.document.print')){
            $action .= "<a href=\"#\" class=\"btn btn-xs bg-gradient-navy\"> Print</a> ";
        }

        $record = [

            'document' => [
                'encoded' => $result->encoded,
                'series' => $result->series,
                'office' => office_helper($result->division),
                'status' => show_status($result->status)
            ],
            'purchase_request' => [
                'number' => $result->purchase_request->number,
                'date' => $result->purchase_request->date,
                'particular' => $result->purchase_request->particular,
                'purpose' => $result->purchase_request->purpose,
                'charging' => $result->purchase_request->charging,
                'accountable' => $result->purchase_request->accountable,
                'amount' => $result->purchase_request->amount,
            ],

            'action' => $action,

            'message' => 'Purchase Request has been encoded.'
        ];

        return response()->json($record, 200);
    }
}
