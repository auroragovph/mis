<?php

namespace Modules\FileManagement\core\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\core\Enums\Document\Status;
use Modules\FileManagement\core\Enums\Document\Track as TrackEnum;
use Modules\FileManagement\core\Models\Document\Track;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\HumanResource\core\Models\Employee\Employee;

class RRController extends Controller
{
    public function index()
    {
        return view('fms::document.rr.index');
    }

    public function form(Request $request)
    {
        $qrcode = $request->post('document');

        // converting DOCUMENT QR
        $id = series($qrcode);

        $document = Series::with('encoder', 'liaison', 'office')->find($id);

        // checking if document exists
        if ($document == null || $document->qr !== $qrcode) {

            // activity loger
            activitylog('document', 'Request to receive or release the document but failed. Reason: ' . message_box('document.not.found'), ['qrcode' => $qrcode]);
            return redirect(route('fms.document.rr.index'))->with('alert-error', 'We cannot find this document. Please check the QR code and try again.');
        }

        // check if document is not cancelled
        if ($document->status === Status::CANCELLED->value) {
            // activity loger
            activitylog('document', 'Request to receive or release the document but failed. Reason: ' . message_box('document.cancelled'), ['qrcode' => $qrcode]);
            return redirect(route('fms.document.rr.index'))->with('alert-error', 'The document has been cancelled.');
        }

        if ($document->status == Status::ACTIVATION->value) {
            activitylog('document', 'Request to receive or release the document but failed. Reason: ' . message_box('document.not.activated'), ['qrcode' => $qrcode]);
            return redirect(route('fms.document.rr.index'))->with('alert-error', message_box('document.not.activated'));
        }

        // converting LIAISON QR TO ID
        $liaison = Employee::find_liaison($request->liaison);

        // checking if the liaison exists
        if ($liaison === null) {

            // activity loger
            activitylog('document', 'Request to receive or release the document but failed. Reason: ' . message_box('employee.liaison.not.found'), ['qrcode' => $qrcode]);
            return redirect(route('fms.document.rr.index'))->with('alert-error', message_box('employee.liaison.not.found'));
        }

        $track = Track::with('office')->where('series_id', $id)->orderBy('created_at', 'DESC')->first();

        // check if you can receive this paper

        if ($track === null) {
            // activity loger
            activitylog('document', 'Request to receive or release the document but failed. Reason: ' . message_box('document.track.not.found'), ['qrcode' => $qrcode]);
            return redirect(route('fms.document.rr.index'))->with('alert-error', message_box('document.track.not.found'));
        }

        //if the document is currently receive
        if ($track->action == TrackEnum::RECEIVE->value) {
            // check if the document is receive in your division/office
            if ($track->division_id != Auth::user()->employee->division_id) {
                $office = office($track->division);
                activitylog('document', 'Request to receive or release the document but failed. Reason: ' . message_box('document.rr.another_office'), ['qrcode' => $qrcode]);
                return redirect(route('fms.document.rr.index'))->with('alert-error', "This document current receive at <b> {$office} </b>. " . message_box('document.rr.release_first'));
            }
        }

        // requiring the switchs
        require module_path('FileManagement', 'core/Includes/SwitchDocument.php');

        // setting session id
        session(['document.edit' => $id]);
        session(['document.liaison' => $liaison->id]);

        ($track->action == TrackEnum::RELEASE->value) ? session(['document.track' => TrackEnum::RECEIVE->value]) : session(['document.track' => TrackEnum::RELEASE->value]);

        // activity loger
        activitylog('document', 'Request to receive or release the document.', ['qrcode' => $qrcode]);

        // dd($document);

        return view('fms::document.rr.form', [
            'document' => $document,
            'datas'    => $datas,
            'track'    => $track,
        ]);
    }

    public function submit(Request $request)
    {
      $id       = session()->pull('document.edit');
      $liaison  = session()->pull('document.liaison');
      $action   = session()->pull('document.track');
      $document = Series::find($id);
      $document->update(['status' => $request->status]);
      $track                = Track::log($id, $action, $request->purpose, $request->status, $liaison);
      ($action == TrackEnum::RELEASE->value) ? $acm = message_box('document.rr.release') : $acm = message_box('document.rr.receive');

      return redirect(route('fms.document.rr.index'))->with('alert-success', $acm);
    }
}
