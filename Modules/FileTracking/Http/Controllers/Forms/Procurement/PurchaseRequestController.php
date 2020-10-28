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

            $documents = FTS_Document::with('purchase_request', 'division')
                            ->where('type', config('constants.document.type.procurement.request'))
                            ->get();

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

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.procurement.request.edit',
                    'id' => $document->id
                ]);


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

        $liaison = employee_id_helper($request->post('liaison'));


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.procurement.request')
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
            'status' => config('constants.document.status.process.id')
        ]);


        return response()->json(['message' => 'Purchase Request has been encoded.'], 200);
    }

    public function edit($id)
    {
        $document = FTS_Document::with('purchase_request')->findOrFail($id);

        // checking if the document is PR
        dm_abort($document->type, config('constants.document.type.procurement.request'));

        $divisions = SYS_Division::with('office')->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);


        return view('filetracking::forms.procurement.request.edit', [
            'divisions' => $divisions,
            'document' => $document
        ]);
    }

    public function update(Request $request, $id)
    {
        // checking the ID if match
        dm_abort(session()->pull('fts.document.edit'), $id);

        $document = FTS_Document::findOrFail($id);

        if($request->post('liaison') != ''){$document->liaison_id = employee_id_helper($request->post('liaison'));}
        $document->division_id = $request->post('division');
        $document->save();

        $pr = FTS_PurchaseRequest::where('document_id', $id)->first();
        $pr->number = $request->post('number');
        $pr->date = $request->post('date');
        $pr->particular = $request->post('particulars');
        $pr->purpose = $request->post('purpose');
        $pr->charging = $request->post('charging');
        $pr->accountable = $request->post('accountable');
        $pr->amount = $request->post('amount');
        $pr->save();

        return redirect(route('fts.procurement.request.index'))->with('alert-success', 'Purchase Request has been updated');

    }
}
