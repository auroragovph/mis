<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;

class AttachmentController extends Controller
{
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
        
        if($request->hasFile('files')){
            // NOTE:: WE WILL DIRECTLY UPLOAD THE FILE. CRON JOBS WILL DECOMPRESS THE IMAGES AND ADD WATERMARKS
            foreach($request->file('files') as $file){

                $mime = $file->getMimeType();

                $image_check = strpos($mime, 'image');
                $pdf_check = strpos($mime, 'pdf');

                if($image_check !== false){
                    $name = $file->getClientOriginalName();

                    $path = $file->store('public/documents');
                    FMS_DocumentAttach::create([
                        'document_id' => $id,
                        'description' => $name,
                        'url' => str_replace('public/documents/', '', $path),
                        'mime' => 'image',
                        'employee_id' => Auth::user()->employee_id
                    ]);

                }

                if($pdf_check !== false){
                    $name = $file->getClientOriginalName();
                    $path = $file->store('documents');
                    FMS_DocumentAttach::create([
                        'document_id' => $id,
                        'description' => $name,
                        'url' => str_replace('public/documents/', '', $path),
                        'mime' => 'pdf',
                        'employee_id' => Auth::user()->employee_id
                    ]);
                }

                continue;
            }
        }


        if($request->tags !== null){
            foreach($request->tags as $i => $tag){
                FMS_DocumentAttach::create([
                    'document_id' => $id,
                    'description' => $tag,
                    'mime' => 'text',
                    'employee_id' => Auth::user()->employee_id
                ]);
            }
        }

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


        return redirect()->back()->with('alert-success', 'Documents has been attached.');
    }
}
