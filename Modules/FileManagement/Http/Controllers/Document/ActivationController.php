<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\Tracking;
use Modules\FileManagement\Http\Requests\Document\ActivationRequest;
use Modules\System\Entities\Employee;

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
        $document = Document::find($id);

        if($document == null || $request->document != $document->qr){
            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: Document not found', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => Document::class
                    ]
                ]
            ]);

            return redirect()
                    ->back()
                    ->with('alert-error', 'Document not found');
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
                        'class' => Document::class
                    ]
                ]
            ]);

            return redirect()->back()->with('alert-error', $response['message']);
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
                        'class' => Document::class
                    ]
                ]
            ]);

            return redirect()->back()->with('alert-error', $response['message']);
        }

        // checking liaison
        $liaison = Employee::find_liaison($request->liaison);

        if($liaison == null){

            $response['message'] = 'Liaison not found.';

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit activation for ID: '. $id. ' but failed. Reason: '.$response['message'], 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => Document::class
                    ]
                ]
            ]);
            return redirect()->back()->with('alert-error', $response['message']);
        }


        $document->status = '2';
        $document->save();

        // save to tracking
        Tracking::log($id, 0, 'Document Activation', 2, (int)$liaison->id);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Submit activation for ID: '.$id, 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => Document::class
                ]
            ]
        ]);


        $response['message'] = 'Document activated.';
        return redirect()->back()->with('alert-success', 'Document has been activated');
    }
}
