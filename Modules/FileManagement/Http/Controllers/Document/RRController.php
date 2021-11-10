<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\Track;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\Tracking;
use Modules\FileManagement\Http\Requests\Document\RRRequest;

class RRController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.rr']);
    }

    public function index()
    {
        return view('filemanagement::actions.rr.index');
    }

    public function form(Request $request)
    {
        $qrcode = $request->post('document');

        // converting DOCUMENT QR
        $id = series($qrcode);

        $document = Document::with('encoder', 'liaison', 'division.office')->find($id);

        // checking if document exists
        if ($document == null || $document->qr !== $qrcode) {

            // activity loger
            actlog('fms', 'Request to receive or release the document but failed. Reason: ' . message_box('document.not.found'), ['qrcode' => $qrcode]);
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'We cannot find this document. Please check the QR code and try again.');
        }

        // check if document is not cancelled
        if ($document->status === 0) {

            // activity loger
            actlog('fms', 'Request to receive or release the document but failed. Reason: ' . message_box('document.cancelled'), ['qrcode' => $qrcode]);
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'The document has been cancelled.');
        }

        
        if ($document->status == 1) {

            // activity loger
            activitylog([
                'name'  => 'fms',
                'log'   => 'Request to receive or release the document but failed. Reason: ' . message_box('document.not.activated'),
                'props' => [
                    'qrcode' => $qrcode,
                ],
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', message_box('document.not.activated'));
        }

        // converting LIAISON QR TO ID
        $liaison = Employee::find_liaison($request->liaison);

        // checking if the liaison exists
        if ($liaison === null) {

            // activity loger
            activitylog([
                'name'  => 'fms',
                'log'   => 'Request to receive or release the document but failed. Reason: ' . message_box('employee.liaison.not.found'),
                'props' => [
                    'qrcode' => $qrcode,
                ],
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', message_box('employee.liaison.not.found'));
        }

        $track = Track::with('division.office')->where('document_id', $id)->orderBy('created_at', 'DESC')->first();

        // check if you can receive this paper

        if ($track === null) {

            // activity loger
            activitylog([
                'name'  => 'fms',
                'log'   => 'Request to receive or release the document but failed. Reason: ' . message_box('document.track.not.found'),
                'props' => [
                    'qrcode' => $qrcode,
                ],
            ]);

            return redirect(route('fms.documents.rr.index'))->with('alert-error', message_box('document.track.not.found'));
        }

        //if the document is currently receive
        if ($track->action == 1) {
            // check if the document is receive in your division/office
            if ($track->division_id != Auth::user()->employee->division_id) {
                $office = office_helper($track->division);

                // activity loger
                activitylog([
                    'name'  => 'fms',
                    'log'   => 'Request to receive or release the document but failed. Reason: '.message_box('document.rr.another_office'),
                    'props' => [
                        'model' => [
                            'id'    => $id,
                            'class' => Document::class,
                        ],
                    ],
                ]);

                return redirect(route('fms.documents.rr.index'))->with('alert-error', "This document current receive at <b> {$office} </b>. ".message_box('document.rr.release_first'));
            }
        }

        // requiring the switchs
        require base_path() . "/Modules/FileManagement/Includes/SwitchDocument.php";

        // setting session id
        session(['fms.document.edit' => $id]);
        session(['fms.document.liaison' => $liaison->id]);

        $action = config('constants.document.action');

        ($track->action == 0) ? session(['fms.document.track' => $action['receive']]) : session(['fms.document.track' => $action['release']]);

        // activity loger
        activitylog([
            'name'  => 'fms',
            'log'   => 'Request to receive or release the document.',
            'props' => [
                'qrcode' => $qrcode
            ],
        ]);

        return view('filemanagement::actions.rr.form', [
            'document' => $document,
            'datas'    => $datas,
            'track'    => $track,
        ]);
    }

    public function submit(RRRequest $request)
    {
        $id       = session()->pull('fms.document.edit');
        $liaison  = session()->pull('fms.document.liaison');
        $action   = session()->pull('fms.document.track');
        $document = Document::find($id);
        $document->update(['status' => $request->status]);
        $track                = Track::log($id, $action, $request->purpose, $request->status, $liaison);
        ($action == 0) ? $acm = message_box('document.rr.release') : $acm = message_box('document.rr.receive');

        return redirect(route('fms.documents.rr.index'))->with('alert-success', $acm);
    }
}
