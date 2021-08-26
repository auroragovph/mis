<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\Track;
use Modules\FileManagement\Http\Requests\Document\ActivationRequest;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.activate']);
    }
    public function index()
    {
        return view('filemanagement::actions.activate.index');
    }

    public function submit(ActivationRequest $request)
    {

        $id = series($request->document);
        $document = Document::find($id);


        if($document === null || $request->document !== $document->qr){

            // activity loger
            actlog('fms', 'Submit activation for ID: '. $id. ' but failed. Reason: Document not found', ['qrcode' => $request->document]);

            return redirect()
                    ->back()
                    ->with('alert-error', 'Document not found');
        }

        if($document->status === 0){

            $response['message'] = 'Document has been cancelled. All further transactions to this document is invalid.';
            actlog('fms', 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], ['qrcode' => $request->document]);
            return redirect()->back()->with('alert-error', $response['message']);
        }

        if($document->status !== 1){

            $response['message'] = 'Document already activated.';
            actlog('fms', 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], ['qrcode' => $request->document]);
            return redirect()->back()->with('alert-error', $response['message']);
        }

        // checking liaison
        $liaison = Employee::find_liaison($request->liaison);

        if($liaison === null){
            $response['message'] = 'Liaison not found.';
            actlog('fms', 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], ['qrcode' => $request->document]);
            return redirect()->back()->with('alert-error', $response['message']);
        }


        $document->status = 2;
        $document->save();

        // save to tracking
        Track::log($id, config('constants.document.action.release'), 'Document Activation', 2, (int)$liaison->id);

        // activity loger
        actlog('fms', 'Activate document. QRCODE: '.$request->document);

        $response['message'] = 'Document activated.';
        return redirect()->back()->with('alert-success', 'Document has been activated');
    }
}
