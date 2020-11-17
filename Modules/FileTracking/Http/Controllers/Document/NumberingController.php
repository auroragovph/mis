<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;

class NumberingController extends Controller
{
    public function __construct()
    {
        // middleware
        $this->middleware(['permission:fts.sa.number']);
    }

    public function index()
    {
        return view('filetracking::documents.numbering');
    }

    public function search(Request $request)
    {
        $id = fts_series($request->input('series'));

        $document = FTS_Document::where('series', $id)->first();


        if($document == null){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to attach number to the document but failed. Reason: Document not found.');

            return response()->json(['message' => 'Document not found!'], 404);
        }

        $numberable = [
            config('constants.document.type.cafoa'),
            config('constants.document.type.travel.order'),
            config('constants.document.type.procurement.request')
        ];
        // $numberable = [500];

        if(!in_array($document->type, $numberable)){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to attach number to the document but failed. Reason: Cannot attach number to the specific document.');

            return response()->json(['message' => 'You cannot attach number to this document'], 406);
        }

       
        // you must receive first the document
        // fetch the latest track of the document
        $logs = FTS_Tracking::where('document_id', $document->id)->orderBy('id', 'DESC')->first();

        if($logs->action !== 1){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to attach number to the document but failed. Reason: Document currently received in another office.');

            return response()->json(['message' => 'Please receive this document first before you attach the number!'], 406);
        }else{
            // check if the document is receive in your division/office
            if($logs->division_id != auth()->user()->employee->division_id){

                // saving the activity logs
                activity('fts')
                ->on(new FTS_Document())
                ->withProperties([
                    'series' => $id,
                    'agent' => user_agent()
                ])
                ->log('Tried to attach number to the document but failed. Reason: Document currently received in another office.');

                return response()->json(['message' => 'Please receive this document first before you attach the number!'], 406);
            }
        }

        $response['status'] = 200;
        $response['message'] = 'Document found. Prepairing the form.';

        switch($document->type){

            case config('constants.document.type.procurement.request'): //PURCHASE REQUEST

                // check if already have a number
                $pr = FTS_PurchaseRequest::where('document_id', $document->id)->first();

                if($pr->number == null){
                    $data = FTS_PurchaseRequest::where('number', '!=', null)->orderBy('id', 'DESC')->get()->first();
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

            case config('constants.document.type.cafoa'): //CAFOA-OBLIGATION REQUEST

                // check if already have a number
                $obr = FTS_Cafoa::where('document_id', $id)->first();

                if($obr->number == null){
                    $data = FTS_Cafoa::where('number', '!=', null)->orderBy('id', 'DESC')->get()->first();
                    $last = ($data !== null) ? $data->number : 'EMPTY' ;
                    $response['data']['type'] = 'LAST CAFOA/OBR NUMBER';
                    $response['data']['last'] = $last;

                    $response['data']['meta']['type'] = $document->type;
                    $response['data']['meta']['id'] = $obr->id;


                }else{
                    $response['status'] = 406;
                    $response['message'] = 'This document has already numbered.';
                }

            break;

            case config('constants.document.type.travel.order'): //TRAVEL ORDER
                $to = FTS_TravelOrder::where('document_id', $document->id)->first();

                if($to->number == null){
                    $data = FTS_TravelOrder::where('number', '!=', null)->orderBy('id', 'DESC')->first();
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

            case config('constants.document.type.cafoa'): // CAFOA
                $cafoa = FTS_Cafoa::where('document_id', $id)->first();

                if($cafoa->number == null){
                    $data = FTS_Cafoa::where('number', '!=', null)->orderBy('id', 'DESC')->first();
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

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to attach number to the document but failed. Reason: '.$response['message'] ?? '');
            
            return response()->json($response, $response['status']);
        }


        // saving the activity logs
        activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'agent' => user_agent()
            ])
            ->log('Tries to attach number to the document.');

        return response()->json($response, 200);
    }

    public function number(Request $request)
    {
        $id = $request->document;
        $type = $request->type;


        switch($type){
            case config('constants.document.type.procurement.request'):  //PURCHASE ORDER
                $document = FTS_PurchaseRequest::find($id);
                $check = FTS_PurchaseRequest::where('number', $request->number)->get()->count();
            break;
            case config('constants.document.type.cafoa'): //OBLIGATION REQUEST
                $document = FTS_Cafoa::find($id);
                $check = FTS_Cafoa::where('number', $request->number)->get()->count();
            break;
            case config('constants.document.type.travel.order'): //TRAVEL ORDER
                $document = FTS_TravelOrder::find($id);
                $check = FTS_TravelOrder::where('number', $request->number)->get()->count();
            break;
            case config('constants.document.type.cafoa'): //CAFOA
                $document = FTS_Cafoa::find($id);
                $check = FTS_Cafoa::where('number', $request->number)->get()->count();
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

                FTS_Tracking::log($document->document_id, 1, 'Attach number to the document', 2);

                $response['message'] = 'Attachment success.';
                $response['status'] = 200;


            }else{
                $response['message'] = 'This number already exists in the database.';
                $response['status'] = 406;
            }
            

        }else{
            $response['message'] = 'Attachment error.';
            $response['status'] = 406;

        }

        if($response['status'] == 406){

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'number' => $request->number,
                'agent' => user_agent()
            ])
            ->log('Attached number to the document but failed. Reason: '.$response['message']);

        }else{

             // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties([
                'series' => $id,
                'number' => $request->number,
                'agent' => user_agent()
            ])
            ->log('Attached number to the document');

        }

        return response()->json($response, $response['status']);

    }
}
