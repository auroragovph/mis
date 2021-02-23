<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_Tracking;
use Modules\FileManagement\Http\Requests\Document\ActivationRequest;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.activate']);
    }
    public function index()
    {
        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request activation form.']);
        return view('filemanagement::documents.activation');
    }

    public function submit(ActivationRequest $request)
    {

        $id = series($request->document);

        $document = FMS_Document::find($id);

        if($document == null || $request->document != $document->qr){
            
            $response['message'] = 'Document not found';

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return response()->json($response, 406);
        }

        if($document->status == '0'){

            $response['message'] = 'Document has been cancelled. All further transactions to this document is invalid.';

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);


            return response()->json($response, 406);
        }

        if($document->status != '1'){

            $response['message'] = 'Document already activated.';

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);


            return response()->json($response, 406);
        }

        // checking liaison

        $liaison = HR_Employee::where('card', employee_id_helper($request->liaison))->first();
        if($liaison == null){

            $response['message'] = 'Liaison ID not found.';

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);


            return response()->json($response, 406);
        }
        if($liaison->liaison == false){

            $response['message'] = 'Employee is not a liaison officer!';

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return response()->json($response, 406);
        }

        $document->status = '2';
        $document->save();

        // save to tracking
        FMS_Tracking::log($id, 0, 'Document Activation', 2, (int)$liaison->id);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Submit activation for ID: '.$id, 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);


        $response['message'] = 'Document activated.';
        return response()->json($response, 200);
    }
}
