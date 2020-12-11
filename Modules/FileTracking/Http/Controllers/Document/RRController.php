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
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class RRController extends DocumentController
{
    public function index()
    {
        return view('filetracking::documents.rr');
    }

    public function form(Request $request)
    {
        $series = fts_series($request->post('series'));


        // checking if this document is included in transmittal
        $start = Carbon::now()->toDateTimeString();
        $end = Carbon::now()->addHour()->toDateTimeString();
        $transmittals = FTS_Transmittal::whereJsonContains('documents', $series)->where('status', 1)->get();
        foreach($transmittals as $transmittal){

            if($transmittal->isExpired == true){
                $transmittal->status = 3;
                $transmittal->save();
                continue;
            }
            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $series,
                'agent' => user_agent()
            ])
            ->log('Tried to received/released the document but failed. Reason: Document currently in transmittal.');
            return redirect()->back()->with('alert-error', 'Document currently in transmittal.');
        }

        


        $document = $this->full($series, ['datas', 'tracks']);

        if(!$document){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $series,
                'agent' => user_agent()
            ])
            ->log('Tried to received/released the document but failed. Reason: Document not Found');

            return redirect()->back()->with('alert-error', 'Series not found.');
        }

        $document = $document['document'];

        if($document['info']['status']['id'] == 0){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $series,
                'agent' => user_agent()
            ])
            ->log('Tried to received/released the document but failed. Reason: Document has been cancelled.');

            return redirect()->back()->with('alert-error', 'Document has been cancelled!');
        }

        // converting LIAISON QR TO ID
        $lid = employee_id_helper($request->liaison, true);
        $liaison = HR_Employee::whereIdCard($lid)->first();

 
        // checking if the liaison exists
        if($liaison == null){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $series,
                'agent' => user_agent()
            ])
            ->log('Tried to received/released the document but failed. Reason: The liaison officer not found.');

            return redirect()->back()->with('alert-error', 'The liaison officer not found.');
        }

        if(config('filetracking.allowAllEmployeesToLiaison') == false){
            if($liaison->liaison == false){

                // saving the activity logs
                activity('fts')
                ->on(new FTS_Document())
                ->withProperties([
                    'series' => $series,
                    'agent' => user_agent()
                ])
                ->log('Tried to received/released the document but failed. Reason: Employee is not registered as liaison.');

                return redirect()->back()->with('alert-error', 'Employee is not registered as liaison.');
            }
        }
        

        $track = $document['tracks'][0];

        // check if you can receive this paper
        //if the document is currently receive
        if($track['action'] == 1){
            // check if the document is receive in your division/office
            if($track['division_id'] != Auth::user()->employee->division_id){
                $office = office_helper($track['division']);

                // saving the activity logs
                activity('fts')
                ->on(new FTS_Document())
                ->withProperties([
                    'series' => $series,
                    'agent' => user_agent()
                ])
                ->log('Tried to received/released the document but failed. Reason: Document was not released.');

                return redirect()->back()->with('alert-error', "This document current receive at <b> {$office} </b>. Please release the document first and try again!");
            }
        }

        // setting session id 
        session(['fts.document.edit' => $document['info']['id']]);
        session(['fts.document.liaison' => $liaison->id]);
        ($track['action'] == 0) ? session(['fts.document.track' => 1]) : session(['fts.document.track' => 0]);


        // saving the activity logs
        activity('fts')
        ->on(new FTS_Document())
        ->withProperties([
            'series' => $series,
            'agent' => user_agent()
        ])
        ->log('Tried to received/released the document.');

        return view('filetracking::documents.rr', [
            'document' => $document
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
        activity('fts')
        ->on(new FTS_Document())
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log($acm);

        return redirect(route('fts.documents.rr.index'))->with('alert-success', $acm);

    }
}
