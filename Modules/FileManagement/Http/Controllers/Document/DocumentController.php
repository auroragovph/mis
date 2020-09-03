<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\FileManagement\Entities\FMS_Tracking;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;

class DocumentController extends Controller
{
    public function index()
    {
        return view('filemanagement::documents.index');
        // abort(500);
    }

    public function redirect($id)
    {
        $document = FMS_Document::findOrFail($id);

         // logging
         FMS_DocumentLog::log($document->id, 'Redirect to the document.');

        $url = 'file-management/';

        switch($document->type){
            case 101: 
                $url .= 'procurement/request/'.$document->id.'/show';
            break;

            case 102: 
                $url .= 'procurement/order/'.$document->id.'/show';
            break;

            case 200: 
                $url .= 'obligation-request/'.$document->id.'/show';
            break;

            case 301: 
                $url .= 'travel/orders/'.$document->id.'/show';
            break;

            default: 
                $url = null;
            break;

        }

        if($url == null){
            abort(404);
        }

        return redirect($url);


    }

    public function cancel($id)
    {
        $document = FMS_Document::findOrFail($id);

        session(['fms.document.edit' => $id]);

         // logging
         FMS_DocumentLog::log($document->id, 'Request cancellation fdrm to the document.');

        return view('filemanagement::documents.cancel',[
            'document' => $document
        ]);
    }

    public function cancel2(Request $request, $id)
    {
        $id = session()->pull('fms.document.edit');

        $document = FMS_Document::find($id);
        $document->status = "0";
        $document->save();

        $track = FMS_Tracking::log($id, 0, $request->reason, "0", 0);

         // logging
         FMS_DocumentLog::log($document->id, 'Cancelled the document.');

        return redirect(route('fms.documents.redirect', $id))
                ->with('alert-success', 'Document has been cancelled. All further transaction to this document is invalid.');

    }
}
