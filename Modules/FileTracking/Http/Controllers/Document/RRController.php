<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class RRController extends Controller
{
    public function index()
    {
        return view('filetracking::documents.rr');
    }

    public function form(Request $request)
    {
        $series = fts_series($request->post('series'));
        $document = FTS_Document::where('series', $series)->first();


        if(!$document){
            return redirect()->back()->with('alert-error', 'Series not found.');
        }

        if($document->status == 0){
            return redirect()->back()->with('alert-error', 'Document has been cancelled!');
        }

        
        // converting LIAISON QR TO ID
        $lid = employee_id_helper($request->liaison);
        $liaison = HR_Employee::whereIdCard($lid)->first();

        dd($lid);

        // checking if the liaison exists
        if($liaison == null){
            return redirect()->back()->with('alert-error', 'The liaison officer not found.');
        }
        if($liaison->liaison == false){
            return redirect()->back()->with('alert-error', 'Employee is not registered as liaison.');
        }

        $track = FTS_Tracking::with('division.office')
                                ->where('document_id', $document->id)
                                ->orderBy('created_at', 'DESC')
                                ->first();

        // check if you can receive this paper
        //if the document is currently receive
        if($track->action == 1){
            // check if the document is receive in your division/office
            if($track->division_id != Auth::user()->employee->division_id){
                $office = office_helper($track->division);
                return redirect()->back()->with('alert-error', "This document current receive at <b> {$office} </b>. Please release the document first and try again!");
            }
        }

        switch($document->type){
            case 101: //PURCHASE REQUEST
                $pr = FTS_PurchaseRequest::where('document_id', $document->id)->first();
                $datas['PR Number'] = $pr->number;
                $datas['Date'] = $pr->date;
                $datas['Particular'] = $pr->particular;
                $datas['Purpose'] = $pr->purpose;
                $datas['Charging'] = $pr->charging;
                $datas['Accountable'] = $pr->accountable;
                $datas['Amount'] = $pr->amount;
            break;
        }

        // setting session id 
        session(['fts.document.edit' => $document->id]);
        session(['fts.document.liaison' => $liaison->id]);
        ($track->action == 0) ? session(['fts.document.track' => 1]) : session(['fts.document.track' => 0]);

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

        return redirect(route('fts.documents.rr.index'))->with('alert-success', $acm);

        

    }
}
