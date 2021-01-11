<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Http\Requests\Document\CancellationRequest;

class CancellationController extends Controller
{
    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request document cancellation form.']);

        return view('filemanagement::documents.cancel');
    }

    public function check(CancellationRequest $request)
    {
        $id = series($request->post('document'));

        $document = FMS_Document::find($id);

        if(!$document || $document->qr != $request->post('document')){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Check document for cancellation but failed. Reason: Document not found.', 
                'props' => [
                    'check' => [
                        'id' => $id
                    ]
                ]
            ]);


            return redirect()->back()->with('alert-error', 'Document not found.');
        }

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Check document for cancellation.',
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);

        return redirect(route('fms.documents.cancel.form', $document->id));
    }

    public function form(FMS_Document $id)
    {
        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request document cancellation form and checked.', 
            'props' => [
                'model' => [
                    'id' => $id->id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);


        return view('filemanagement::documents.cancel', ['document' => $id]);
    }

    public function submit(CancellationRequest $request, $id)
    {
        $document = FMS_Document::findOrFail($id);
        $document->update([
            'status' => 0
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Submit document cancellation',
            'props' => [
                'model' => [
                    'id' => $id->id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);

        return redirect(route('fms.documents.cancel.index'))->with('alert-success', 'Document has been cancelled.');
    }
}
