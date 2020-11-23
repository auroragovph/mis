<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

class CafoaController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $documents = FTS_Document::with('cafoa', 'division.office')
                            ->whereHas('cafoa')
                            ->where('type', config('constants.document.type.cafoa'))
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){
                
                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['status'] = show_status($document->status);


                $records['data'][$i]['number'] = $document->cafoa->number;
                $records['data'][$i]['payee'] = $document->cafoa->payee;
                $records['data'][$i]['amount'] = number_format($document->cafoa->amount, 2);
                $records['data'][$i]['particulars'] = $document->cafoa->particulars;

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.cafoa.edit',
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

        return view('filetracking::forms.cafoa.index',[
            'divisions' => $divisions ?? null,
            'qrs' => $qrs ?? null,
            'liaisons' => $liaisons ?? null,
            'attachments' => $attachments ?? null,
            
        ]);
    }

    public function store(Request $request)
    {
        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store CAFOA document but failed. Reason: You dont have the permissions to execute this command.');

            return abort(403);
        }

        $series = fts_series($request->post('series'));

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){
            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store CAFOA document but failed. Reason: Series Number already exists');


            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.cafoa')
        ]);

        $attachments = array();
        foreach($request->post('attachments') as $i => $attachment){
            $attachments[$i]['document_id'] = $document->id;
            $attachments[$i]['employee_id'] = auth()->user()->employee_id;
            $attachments[$i]['description'] = $attachment;
            $i++;
        }
        FTS_DA::insert($attachments);

        $cafoa = FTS_Cafoa::create([
            'document_id' => $document->id,
            'number' => $request->post('number'),
            'payee' => $request->post('payee'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars')
        ]);

        // changing QR status
        $qr = FTS_Qr::used($series);

        // INSERTING INTO TRACKING LOGS
        FTS_Tracking::create([
            'document_id' => $document->id,
            'division_id' => Auth::user()->employee->division_id,
            'user_id' => Auth::user()->employee_id,
            'liaison_id' => $liaison,
            'action' => config('constants.document.action.release'),
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(Auth::user()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'document_id' => $document->id,
            'agent' => user_agent()
        ])
        ->log('Tried to store CAFOA document.');

        return response()->json([
            'message' => 'CAFOA has been encoded.',
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
                'document_id' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to edit CAFOA document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::with('cafoa')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.cafoa'));

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'agent' => user_agent()
        ])
        ->log('Edit CAFOA document.');


        return view('filetracking::forms.cafoa.edit', [
            'divisions' => $divisions,
            'liaisons' => $liaisons,
            'document' => $document
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
                'document_id' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to update CAFOA document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $cafoa = FTS_Cafoa::where('document_id', $document->id)->first();
        $cafoa->number = $request->post('number');
        $cafoa->payee = $request->post('payee');
        $cafoa->amount = $request->post('amount');
        $cafoa->particulars = $request->post('particulars');
        $cafoa->save();


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'document_id' => $id,
            'agent' => user_agent()
        ])
        ->log('Update CAFOA document.');

        return redirect(route('fts.cafoa.index'))->with('alert-success', 'CAFOA has been updated.');
    }
}
