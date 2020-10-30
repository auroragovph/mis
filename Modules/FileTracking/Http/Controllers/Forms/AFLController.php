<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

class AFLController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $documents = FTS_Document::with('afl', 'division.office')
                            ->whereHas('afl')
                            ->where('type', config('constants.document.type.afl'))
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['status'] = show_status($document->status);


                $records['data'][$i]['name'] = $document->afl->name;
                $records['data'][$i]['position'] = $document->afl->position;
                $records['data'][$i]['type'] = $document->afl->type;
                $records['data'][$i]['inclusives'] = implode(', ', $document->afl->inclusives);

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.afl.edit',
                    'id' => $document->id
                ]);


                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);
        }


        $divisions = SYS_Division::with('office')->get();
        $qrs = FTS_Qr::where('status', false)->get();
        $liaisons = HR_Employee::liaison()->get();


        return view('filetracking::forms.afl.index',[
            'liaisons' => $liaisons,
            'divisions' => $divisions,
            'qrs' => $qrs
        ]);
    }

    public function store(Request $request)
    {
        $series = $request->post('series');

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
        $qr = FTS_Qr::find($series);
        $qr->status = true;
        $qr->save();

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

        return response()->json(['message' => 'Application for leave has been encoded.'], 200);
    }

    public function edit($id)
    {
        $document = FTS_Document::with('afl')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.afl'));

        $divisions = SYS_Division::with('office')->get();
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
