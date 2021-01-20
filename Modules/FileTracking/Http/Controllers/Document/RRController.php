<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Document\FTS_Transmittal;

class RRController extends Controller
{
    public function index()
    {
        return view('filetracking::documents.rr');
    }

    public function form(Request $request)
    {
        $series = fts_series($request->post('series'));

        $document = FTS_Document::with('division.office', 'encoder', 'liaison')->where('series', $series)->first();

        if($document->status == 0){
            return redirect()->back()->with('alert-error', 'Document has been cancelled.');
        }

        // converting LIAISON QR TO ID
        $lid = employee_id_helper($request->liaison, true);
        $liaison = HR_Employee::whereIdCard($lid)->first();

        // checking if the liaison exists
        if($liaison == null){
            return redirect()->back()->with('alert-error', 'The liaison officer not found.');
        }

        // checking if the employees 
        if(config('filetracking.allowAllEmployeesToLiaison') == false){
            if($liaison->liaison == false){
                return redirect()->back()->with('alert-error', 'Employee is not registered as liaison.');
            }
        }

        $track = FTS_Tracking::with('division.office')->where('document_id', $document->id)->latest('created_at')->first();

        // check if you can receive this paper
        //if the document is currently receive
        if($track->action == 1){
            // check if the document is receive in your division/office
            if($track['division_id'] != Auth::user()->employee->division_id){
                $office = office_helper($track->division);
                return redirect()->back()->with('alert-error', "This document current receive at <b> {$office} </b>. Please release the document first and try again!");
            }
        }

        // setting session id 
        session(['fts.document.edit' => $document->id]);
        session(['fts.document.liaison' => $liaison->id]);
        ($track->action == 0) ? session(['fts.document.track' => 1]) : session(['fts.document.track' => 0]);


        require base_path()."/Modules/FileTracking/Includes/SwitchDocument.php";


        return view('filetracking::documents.rr', [
            'document' => $document,
            'datas' => $datas,
            'track' => $track
        ]);

    }

    public function submit(Request $request)
    {
        $id = session()->pull('fts.document.edit');
        $liaison = session()->pull('fts.document.liaison');
        $action = session()->pull('fts.document.track');

        $track = FTS_Tracking::log($id, $action, $request->purpose, $request->status, $liaison);

        // changing document status
        $document = FTS_Document::find($id);
        $document->status = $request->post('status');
        $document->save();

        ($action == 0) ? $acm = 'Document has been release.' : $acm = 'Document has been receive.' ;

        // saving the activity logs
        return response()->json(['message' => $acm, 'route' => route('fts.documents.rr.index')]);
    }
}
