<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

class AFLController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $timer = $timer = microtime(true);

            $documents = FTS_Document::with('afl', 'division.office')
                            ->where('type', config('constants.document.type.afl'))
                            ->get();

            $records['data'] = array();

            $count = 0;
            foreach($documents as $i => $document){

                if($document->afl == null){continue;}

                $records['data'][$count]['id'] = $document->id;
                $records['data'][$count]['encoded'] = $document->encoded;
                $records['data'][$count]['series'] = $document->seriesFull;
                $records['data'][$count]['office'] = office_helper($document->division);
                $records['data'][$count]['status'] = show_status($document->status);


                $records['data'][$count]['name'] = $document->afl->name;
                $records['data'][$count]['position'] = $document->afl->position;
                $records['data'][$count]['type'] = $document->afl->type;
                $records['data'][$count]['inclusives'] = implode(', ', $document->afl->inclusives);

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.afl.edit',
                    'id' => $document->id
                ]);


                $records['data'][$count]['action'] = $action;

                $count++;
            }

            $records['time'] = microtime(true) - $timer;

            return response()->json($records, 200);
        }


        if(auth()->user()->can('fts.document.create')){
            $divisions = SYS_Division::lists();
            $qrs = FTS_Qr::available();
            $liaisons = HR_Employee::liaison()->get();
            $attachments = FTS_DA::lists();

        }

        return view('filetracking::forms.afl.index',[
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
            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $series = fts_series($request->post('series'));

        if($request->post('inclusive') == null){
            return response()->json(['message' => 'Please select inclusive dates!'], 406);
        }

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
            'type' => config('constants.document.type.afl')
        ]);

        $attachments = array();
        foreach($request->post('attachments') as $i => $attachment){
            $attachments[$i]['document_id'] = $document->id;
            $attachments[$i]['employee_id'] = auth()->user()->employee_id;
            $attachments[$i]['description'] = $attachment;
            $i++;
        }
        FTS_DA::insert($attachments);


        $leave = [
            'vacation' => [$request->post('v1'), $request->post('v2')],
            'sick' => [$request->post('s1'), $request->post('s2')]
        ];

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl = FTS_AFL::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'type' => $request->post('type'),
            'credits' => $request->post('credits'),
            'leave' => $leave,
            'inclusives' => $inclusives->sort()->values()->all(),
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

        return response()->json([
            'message' => 'Application for leave has been encoded.',
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
            return abort(403);
        }

        $document = FTS_Document::with('afl')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.afl'));

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        return view('filetracking::forms.afl.edit', [
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
            return abort(403);
        }
        
        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $leave = [
            'vacation' => [$request->post('v1'), $request->post('v2')],
            'sick' => [$request->post('s1'), $request->post('s2')]
        ];

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl = FTS_AFL::where('document_id', $id)->first();
        $afl->name = $request->post('name');
        $afl->position = $request->post('position');
        $afl->type = $request->post('type');
        $afl->credits = $request->post('credits');
        $afl->leave = $leave;
        $afl->inclusives = $inclusives;
        $afl->save();

        return redirect(route('fts.afl.index'))->with('alert-success', 'Application for leave has been updated.');
    }
}
