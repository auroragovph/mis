<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\FMS_Tracking;

class ActivationController extends Controller
{

    public function __construct()
    {
        // middleware
        $this->middleware(['permission:fms.sa.activate']);
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('filemanagement::documents.activate');
    }

    public function info(Request $request)
    {

        $id = series_to_id($request->document);

        

        $document = FMS_Document::find($id);

        if($document == null){
            $response['message'] = 'Document not found';
            return response()->json($response, 406);
        }

        if($document->status == '0'){
            $response['message'] = 'Document has been cancelled. All further transactions to this document is invalid.';
            return response()->json($response, 406);
        }

        if($document->status != '1'){
            $response['message'] = 'Document already activated.';
            return response()->json($response, 406);
        }

        $document->status = '2';
        $document->save();


        // save to tracking
        FMS_Tracking::log($id, 0, 'Document Activation', 2, (int)$request->liaison);


        // logging
        FMS_DocumentLog::log($document->id, 'Activate the document.');


        $response['message'] = 'Document activated.';
        return response()->json($response, 200);


    }

}
