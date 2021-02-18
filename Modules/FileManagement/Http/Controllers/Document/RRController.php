<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_Tracking;
use Modules\FileManagement\Http\Requests\Document\RRRequest;

class RRController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.rr']);
    }

    public function index()
    {
        return view('filemanagement::documents.rr');
    }

    public function form(Request $request)
    {
        // converting DOCUMENT QR
        $id = series($request->document);

        $document = FMS_Document::with('encoder', 'liaison', 'division.office')->find($id);

        // checking if document exists
        if($document == null || $document->qr !== $request->document){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request to receive or release the document but failed. Reason: Document not found.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'We cannot find this document. Please check the QR code and try again.');
        }

        // check if document is not cancelled
        if($document->status == 0){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request to receive or release the document but failed. Reason: Document was cancelled.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'The document has been cancelled.');
        }

        // check if document is activated
        if($document->status == 1){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request to receive or release the document but failed. Reason: Document is not activated.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'Please activate the document first.');
        }

        // converting LIAISON QR TO ID
        $lid = employee_id_helper($request->liaison);
        $liaison = HR_Employee::whereIdCard($lid)->first();

        // checking if the liaison exists
        if($liaison == null){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request to receive or release the document but failed. Reason: Liaison officer not found.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'The liaison officer not found.');
        }
        if($liaison->liaison == false){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request to receive or release the document but failed. Reason: Employee is not registered as liaison.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'Employee is not registered as liaison.');
        }


        $track = FMS_Tracking::with('division.office')->where('document_id', $id)->orderBy('created_at', 'DESC')->first();

        // check if you can receive this paper

        if($track == null){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request to receive or release the document but failed. Reason: Tracks not found.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);
            
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'Tracks not found.');
        }
        //if the document is currently receive
        if($track->action == 1){
            // check if the document is receive in your division/office
            if($track->division_id != Auth::user()->employee->division_id){
                $office = office_helper($track->division);


                // activity loger
                activitylog([
                    'name' => 'fms',
                    'log' => 'Request to receive or release the document but failed. Reason: Document was received in another office.', 
                    'props' => [
                        'model' => [
                            'id' => $id,
                            'class' => FMS_Document::class
                        ]
                    ]
                ]);


                return redirect(route('fms.documents.rr.index'))->with('alert-error', "This document current receive at <b> {$office} </b>. Please release the document first and try again!");
            }
        }

        // requiring the switchs
        require base_path()."/Modules/FileManagement/Includes/SwitchDocument.php";

        // setting session id 
        session(['fms.document.edit' => $id]);
        session(['fms.document.liaison' => $liaison->id]);
        ($track->action == 0) ? session(['fms.document.track' => 1]) : session(['fms.document.track' => 0]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request to receive or release the document.', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);

        return view('filemanagement::documents.rr', [
            'document' => $document,
            'datas' => $datas,
            'track' => $track
        ]);
    }

    public function submit(RRRequest $request)
    {
        $id = session()->pull('fms.document.edit');
        $liaison = session()->pull('fms.document.liaison');
        $action = session()->pull('fms.document.track');
        $document = FMS_Document::find($id);
        $document->update(['status' => $request->status]);
        $track = FMS_Tracking::log($id, $action, $request->purpose, $request->status, $liaison);
        ($action == 0) ? $acm = 'Document has been release.' : $acm = 'Document has been receive.' ;

        // logging
        // FMS_DocumentLog::log($id, $acm);

        return response()->json(['message' => $acm, 'route' => route('fms.documents.rr.index')]);
    }
}
