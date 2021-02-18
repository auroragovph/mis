<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.attach']);
    }

    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request document attach form.']);

        return view('filemanagement::documents.attach');
    }

    public function check(Request $request)
    {
        $id = series($request->document);

        $document = FMS_Document::find($id);

        if($document == null || $document->qr !== $request->document){

            // activity loger
            activitylog([
                'name' => 'fms',
                'log' => 'Submit attachment for ID: '. $id. ' but failed. Reason: Document not found.', 
                'props' => [
                    'model' => [
                        'id' => $id,
                        'class' => FMS_Document::class
                    ]
                ]
            ]);

            return redirect()->back()->with('alert-error', 'Document not found');
        }

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Check document if exists for attachment controller.', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);

        return redirect(route('fms.documents.attach.form', $document->id));
    }

    public function form($id)
    {
        $document = FMS_Document::with('attachments')->findOrFail($id);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Attachment form', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);


        return view('filemanagement::documents.attach', [
            'document' => $document
        ]);
    }

    public function attach(Request $request, $id)
    {
        
        $mime = '';
        
        if($request->hasFile('file')){

            $mime = 'file';

            $file = $request->file('file');
            // $path = Storage::store;
            $path = $file->store('filemanagement/document/attachments');
        }

        $attachment = FMS_DocumentAttach::create([
            'document_id' => $id,
            'description' => $request->post('name'), 
            'url'  => (isset($path)) ? str_replace('filemanagement/document/attachments/', '', $path) : null,
            'mime' => ($mime == '') ? 'text' : 'file',
            'properties' => array(
                'number'    => $request->post('number') ?? null, 
                'date'      => $request->post('date')   ?? null, 
                'amount'    => $request->post('amount') ?? null, 
                'page'      => $request->post('page')   ?? null, 
            )
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Add attachment to the document.', 
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => FMS_Document::class
                ]
            ]
        ]);

        return response()->json([
            'message' => 'Attachment success'
        ]);
    }

    public function file($file)
    {
        return response()->file(storage_path('app/filemanagement/document/attachments/'.$file));
    }
}
