<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class PurchaseRequestController extends Controller
{
    
    public function index(Request $request)
    {


        if($request->ajax()){

            $documents = FTS_Document::with('purchase_request', 'division')
                            ->whereHas('purchase_request')
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
                $records['data'][$i]['amount'] = number_format($document->purchase_request->amount, 2);
                $records['data'][$i]['status'] = show_status($document->status);

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.procurement.request.edit',
                    'id' => $document->id
                ]);

                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);


        }

        
        if(auth()->user()->can('fts.document.create')){
            $divisions = SYS_Division::lists();
            $qrs = FTS_Qr::available();
            $liaisons = HR_Employee::liaison()->get();
            $attachments = FTS_DA::lists();
        }

        return view('filetracking::forms.procurement.request.index',[
            'divisions' => $divisions ?? null,
            'qrs' => $qrs ?? null,
            'liaisons' => $liaisons ?? null,
            'attachments' => $attachments ?? null,

        ]);
    }

    public function store(Request $request)
    {
        // checking permissions
        if(!auth()->user()->can('fts.document.create')){
            // saving the activity logs
            actlog('fts', "Tried to store purchase request document but failed. Reason: You dont have the permissions to execute this command.");
            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }


        $series = $request->post('series');

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store purchase request document but failed. Reason: Series Number already exists.');

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        // $liaison = employee_id_helper($request->post('liaison'));
        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.procurement.request')
        ]);

        $attachments = array();
        foreach($request->post('attachments') as $i => $attachment){
            $attachments[$i]['document_id'] = $document->id;
            $attachments[$i]['employee_id'] = auth()->user()->employee_id;
            $attachments[$i]['description'] = $attachment;
            $i++;
        }
        FTS_DA::insert($attachments);

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
        $qr = FTS_Qr::used($series);

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

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'agent' => user_agent()
        ])
        ->log('Encode purchase request document');

        return response()->json([
            'message' => 'Purchase Request has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ], 200);
    }

    public function edit($id)
    {
        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to edit purchase request document but failed. Reason: Not enough permission to edit the document.');

            return abort(403);
        }

        $document = FTS_Document::with('purchase_request')->findOrFail($id);

        // checking if the document is PR
        dm_abort($document->type, config('constants.document.type.procurement.request'));

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();


        // setting up the sessions
        session(['fts.document.edit' => $document->id]);


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Tried to edit purchase request document.');


        return view('filetracking::forms.procurement.request.edit', [
            'divisions' => $divisions,
            'document' => $document,
            'liaisons' => $liaisons
        ]);
    }

    public function update(Request $request, $id)
    {
        // checking the ID if match
        dm_abort(session()->pull('fts.document.edit'), $id);

        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){
            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to edit purchase request document but failed. Reason: Not enough permission to edit the document.');
            return abort(403);
        }

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


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Update the purchase request document');



        return redirect(route('fts.procurement.request.index'))->with('alert-success', 'Purchase Request has been updated');

    }
}
