<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\FMS_Document;
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

        return view('filemanagement::documents.cancel');
    }

    public function form(CancellationRequest $request)
    {
        $id = series($request->post('document'));

        $document = Document::find($id);

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
            'log' => 'Request document cancellation form and checked.', 
            'props' => [
                'model' => [
                    'id' => $document->id,
                    'class' => Document::class
                ]
            ]
        ]);


        return view('filemanagement::documents.cancel', ['document' => $document]);
    }

    public function submit(CancellationRequest $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->update([
            'status' => 0
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Submit document cancellation',
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => Document::class
                ]
            ]
        ]);

        return redirect(route('fms.documents.cancel.index'))->with('alert-success', 'Document has been cancelled.');
    }
}
