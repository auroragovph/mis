<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\Track;
use Modules\FileManagement\Http\Requests\Document\CancellationRequest;

class CancellationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.document.cancel']);
    }

    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request document cancellation form.']);

        return view('filemanagement::actions.cancel.index');
    }

    public function form(Request $request)
    {

        $qrcode = $request->get('qrcode');
        $id = series($qrcode);

        $document = Document::find($id);

        if(!$document){
            actlog('fms', 'Check document for cancellation but failed. Reason: Document not found.', ['qrcode' => $qrcode]);
            return redirect()->back()->with('alert-error', 'Document not found.');
        }

        if($document->status === config('constants.document.status.cancelled.id')){
            actlog('fms', 'Check document for cancellation but failed. Reason: Document already cancelled.', ['qrcode' => $qrcode]);
            return redirect()->back()->with('alert-error', 'Document already cancelled.');
        }

        // setting session
        $request->session()->put('fms.document.cancel', $id);

        // activity log
        actlog('fms', 'Request document cancellation form and checked.', ['qrcode' => $qrcode]);

        return view('filemanagement::actions.cancel.form', ['document' => $document]);
    }

    public function submit(CancellationRequest $request)
    {
        $id = $request->session()->pull('fms.document.cancel');

        $document = Document::find($id);
        $qrcode = $document->qrcode;

        if(!$document){
            actlog('fms', 'Check document for cancellation but failed. Reason: Document not found.', ['qrcode' => $qrcode]);
            return redirect()->back()->with('alert-error', 'Document not found.');
        }

        if($document->status === config('constants.document.status.cancelled.id')){
            actlog('fms', 'Check document for cancellation but failed. Reason: Document already cancelled.', ['qrcode' => $qrcode]);
            return redirect()->back()->with('alert-error', 'Document already cancelled.');
        }

        $document->update([
            'status' => 0
        ]);

        // adding received in tracking logs
        $track = Track::log($id, 1, $request->post('reason'), 0, null);

        // activity loger
        actlog('fms', 'Submit document cancellation', ['qrcode' => $document->qr]);

        // flashing session
        session()->flash('alert-success', 'Document has been cancelled.');

        if($request->get('referer') !== null){
            return redirect($request->get('referer'));
        }

        return redirect(route('fms.documents.cancel.index'));
    }
    
}
