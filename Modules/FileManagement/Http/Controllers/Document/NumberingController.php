<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_Tracking;
use Modules\FileManagement\Entities\Procurement\FMS_PR;
use Modules\FileManagement\Entities\Travel\FMS_TO;

class NumberingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.number']);
    }

    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request numbering form.']);
        return view('filemanagement::documents.numbering');
    }

    public function search(Request $request)
    {
        $id = series($request->document);

        $document = FMS_Document::find($id);

        if($document == null || $document->qr != $request->document){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request numbering of document but failed. Reason: Document not found!', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return response()->json(['message' => 'Document not found!'], 406);
        }


        $numberable = [
            config('constants.document.type.procurement.request'),
            config('constants.document.type.procurement.order'),
            config('constants.document.type.cafoa'),
            config('constants.document.type.travel.order')
        ];

        if(!in_array($document->type, $numberable)){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request numbering of document but failed. Reason: Document is not numberable.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return response()->json(['message' => 'You cannot attach number to this document'], 406);
        }

        if($document->status == '1'){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request numbering of document but failed. Reason: Document is not activated.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return response()->json(['message' => 'Please activate this document first!'], 406);
        }


        // you must receive first the document
        // fetch the latest track of the document
        $logs = FMS_Tracking::where('document_id', $id)->orderBy('id', 'DESC')->first();
        if($logs->action !== 1){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request numbering of document but failed. Reason: Document is not currently received.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return response()->json(['message' => 'Please receive this document first before you attach the number!'], 406);
        }else{
            // check if the document is receive in your division/office
            if($logs->division_id != authenticated()->employee->division_id){

                // activity loger
                activitylog([
                    'name' => 'fms',
                    'log' => 'Request numbering of document but failed. Reason: Document is not currently received.', 
                    'props' => [
                        'model' => [
                            'id' => $id,
                            'class' => FMS_Document::class
                        ]
                    ]
                ]);

                return response()->json(['message' => 'Please receive this document first before you attach the number!'], 406);
            }
        }

        $response['status'] = 200;
        $response['message'] = 'Document found. Prepairing the form.';

        require base_path()."/Modules/FileManagement/Includes/SwitchDocumentNumber.php";
        

        if($response['status'] !== 200){
            return response()->json($response, $response['status']);
        }


        // setting session for checking if it was searched
        session(['fms.document.numbering' => [
            'id' => $response['data']['meta']['id'],
            'type' => $response['data']['meta']['type']
        ]]);


        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Search document for numbering', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);

        return response()->json($response, 200);
    }

    public function number(Request $request)
    {
        $details = session()->pull('fms.document.numbering');

        if(!$details || $details == null){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Request numbering of document but failed. Reason: Session not found.'
            ]);

            return response()->json(['message' => 'Session not found'], 406);
        }


        $id = $details['id'];
        $type = $details['type'];

        switch($type){
            case config('constants.document.type.procurement.request'):  //PURCHASE ORDER
                $document = FMS_PR::find($id);
                $check = FMS_PR::where('number', $request->number)->get()->count();
            break;
           
            case config('constants.document.type.travel.order'): //TRAVEL ORDER
                $document = FMS_TO::find($id);
                $check = FMS_TO::where('number', $request->number)->get()->count();
            break;
            case config('constants.document.type.cafoa'): //CAFOA
                $document = FMS_Cafoa::find($id);
                $check = FMS_Cafoa::where('number', $request->number)->get()->count();
            break;
            default: 
                $document = null;
            break;
        }

        if($document !== null){

            if($check == 0){

                $document->update([
                    'number' => $request->post('number')
                ]);

                FMS_Tracking::log($document->document_id, 1, 'Attach number to the document', 2);

                $response['message'] = 'Attachment success.';
                $response['status'] = 200;

                 // logging
                // FMS_DocumentLog::log($document->id, 'Attach number to the document.');

            }else{
                 // logging
                // FMS_DocumentLog::log($document->id, 'Failed to attach number to the document. Reason: number already exists');

                $response['message'] = 'This number already exists in the database.';
                $response['status'] = 406;
            }
            

        }else{
            $response['message'] = 'Attachment error.';
            $response['status'] = 406;

        }


        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request numbering of document. Message: '.$response['message'], 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);


        return response()->json($response, $response['status']);

    }
}
