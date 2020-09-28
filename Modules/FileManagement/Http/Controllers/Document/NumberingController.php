<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\FMS_Tracking;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Obr\FMS_ObligationRequest;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;

class NumberingController extends Controller
{
    public function __construct()
    {
        // middleware
        $this->middleware(['permission:fms.sa.number']);
    }


    public function index()
    {
        return view('filemanagement::documents.numbering');
    }

    public function search(Request $request)
    {
        $id = series($request->document);

        $document = FMS_Document::find($id);

        if($document == null || $document->qr != $request->document){
            return response()->json(['message' => 'Document not found!'], 404);
        }


        // logging
        FMS_DocumentLog::log($document->id, 'Check the document if numberable.');

        $numberable = [101, 102, 200, 301, 400];
        // $numberable = [500];

        if(!in_array($document->type, $numberable)){
            return response()->json(['message' => 'You cannot attach number to this document'], 406);
        }

        if($document->status == '1'){
            return response()->json(['message' => 'Please activate this document first!'], 406);
        }


        // you must receive first the document
        // fetch the latest track of the document
        $logs = FMS_Tracking::where('document_id', $id)->orderBy('id', 'DESC')->first();
        if($logs->action !== 1){
            return response()->json(['message' => 'Please receive this document first before you attach the number!'], 406);
        }else{
            // check if the document is receive in your division/office
            if($logs->division_id != Auth::user()->employee->division_id){
                return response()->json(['message' => 'Please receive this document first before you attach the number!'], 406);
            }
        }

        $response['status'] = 200;
        $response['message'] = 'Document found. Prepairing the form.';

        switch($document->type){

            case 101: //PURCHASE REQUEST

                // check if already have a number
                $pr = FMS_PurchaseRequest::where('document_id', $id)->get()->first();

                if($pr->number == null){
                    $data = FMS_PurchaseRequest::where('number', '!=', null)->orderBy('id', 'DESC')->get()->first();
                    $last = ($data !== null) ? $data->number : 'EMPTY' ;
                    $response['data']['type'] = 'LAST PR NUMBER';
                    $response['data']['last'] = $last;

                    $response['data']['meta']['type'] = $document->type;
                    $response['data']['meta']['id'] = $pr->id;


                }else{
                    $response['status'] = 406;
                    $response['message'] = 'This document has already numbered.';
                }
                
            break;

            case 200: //OBLIGATION REQUEST

                // check if already have a number
                $obr = FMS_ObligationRequest::where('document_id', $id)->get()->first();

                if($obr->number == null){
                    $data = FMS_ObligationRequest::where('number', '!=', null)->orderBy('id', 'DESC')->get()->first();
                    $last = ($data !== null) ? $data->number : 'EMPTY' ;
                    $response['data']['type'] = 'LAST OBR NUMBER';
                    $response['data']['last'] = $last;

                    $response['data']['meta']['type'] = $document->type;
                    $response['data']['meta']['id'] = $obr->id;


                }else{
                    $response['status'] = 406;
                    $response['message'] = 'This document has already numbered.';
                }

            break;

            case 301: //TRAVEL ORDER
                $to = FMS_TravelOrder::where('document_id', $id)->first();

                if($to->number == null){
                    $data = FMS_TravelOrder::where('number', '!=', null)->orderBy('id', 'DESC')->first();
                    $last = ($data !== null) ? $data->number : 'EMPTY' ;
                    $response['data']['type'] = 'LAST TO NUMBER';
                    $response['data']['last'] = $last;

                    $response['data']['meta']['type'] = $document->type;
                    $response['data']['meta']['id'] = $to->id;
                }else{
                    $response['status'] = 406;
                    $response['message'] = 'This document has already numbered.';
                }
            break;

            case 400: // CAFOA
                $cafoa = FMS_Cafoa::where('document_id', $id)->first();

                if($cafoa->number == null){
                    $data = FMS_TravelOrder::where('number', '!=', null)->orderBy('id', 'DESC')->first();
                    $last = ($data !== null) ? $data->number : 'EMPTY' ;
                    $response['data']['type'] = 'LAST CAFOA NUMBER';
                    $response['data']['last'] = $last;

                    $response['data']['meta']['type'] = $document->type;
                    $response['data']['meta']['id'] = $cafoa->id;
                }else{
                    $response['status'] = 406;
                    $response['message'] = 'This document has already numbered.';
                }
            break;


            default: 
                $response['status'] = 406;
                $response['message'] = 'You cannot attach number to this document';
            break;
        }

        if($response['status'] !== 200){
            return response()->json($response, $response['status']);
        }

        return response()->json($response, 200);
    }

    public function number(Request $request)
    {
        $id = $request->document;
        $type = $request->type;


        switch($type){
            case 101:  //PURCHASE ORDER
                $document = FMS_PurchaseRequest::find($id);
                $check = FMS_PurchaseRequest::where('number', $request->number)->get()->count();
            break;
            case 200: //OBLIGATION REQUEST
                $document = FMS_ObligationRequest::find($id);
                $check = FMS_ObligationRequest::where('number', $request->number)->get()->count();
            break;
            case 301: //TRAVEL ORDER
                $document = FMS_TravelOrder::find($id);
                $check = FMS_TravelOrder::where('number', $request->number)->get()->count();
            break;
            case 400: //CAFOA
                $document = FMS_Cafoa::find($id);
                $check = FMS_Cafoa::where('number', $request->number)->get()->count();
            break;
            default: 
                $document = null;
            break;
        }

        // dd($document);

        if($document !== null){

            if($check == 0){

                $document->number = $request->number;
                $document->save();

                FMS_Tracking::log($document->document_id, 1, 'Attach number to the document', 2);

                $response['message'] = 'Attachment success.';
                $response['status'] = 200;

                 // logging
                FMS_DocumentLog::log($document->id, 'Attach number to the document.');

            }else{
                 // logging
                FMS_DocumentLog::log($document->id, 'Failed to attach number to the document. Reason: number already exists');

                $response['message'] = 'This number already exists in the database.';
                $response['status'] = 406;
            }
            

        }else{
            $response['message'] = 'Attachment error.';
            $response['status'] = 406;

        }


        return response()->json($response, $response['status']);

    }
}
