<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;

class AttachmentController extends Controller
{
    public function __construct()
    {
        // middleware
        $this->middleware(['permission:fms.sa.attach']);
    }


    public function index()
    {
        return view('filemanagement::documents.attach');
    }

    public function check(Request $request)
    {
        $id = series_to_id($request->document);

        $document = FMS_Document::find($id);

        if($document == null){
            return redirect()->back()->with('alert-error', 'Document not found');
        }

         // logging
         FMS_DocumentLog::log($document->id, 'Check the document if exists.');



        return redirect(route('fms.documents.attach.form', $document->id));


    }

    public function form($id)
    {
        $document = FMS_Document::with('attachments')->findOrFail($id);

         // logging
         FMS_DocumentLog::log($document->id, 'Request attachment form for the document');

        // dd($document);

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
                        'url' => $path,
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
                        'url' => $path,
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

         // logging
         FMS_DocumentLog::log($id, 'Add attachments to the document');


        return redirect()->back()->with('alert-success', 'Documents has been attached.');
    }
}
