<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Http\Requests\Document\AttachmentStoreRequest;

class AttachmentController extends Controller
{
    public function index()
    {
        return view('filetracking::documents.attachment');
    }

    public function check(Request $request)
    {
        $series = fts_series($request->post('series'));

        $document = FTS_Document::where('series', $series)->first();

        if(!$document){
            return redirect()->back()->with('alert-error', 'Document not found.');
        }

        return redirect(route('fts.documents.attach.form', $document->id));

    }

    public function form($id)
    {
        $document = FTS_Document::with('encoder', 'liaison', 'division.office', 'attachments.encoder')->findOrFail($id);

        require base_path()."/Modules/FileTracking/Includes/SwitchDocument.php";

        return view('filetracking::documents.attachment', [
            'document'  => $document,
            'datas'     => $datas
        ]);
    }

    public function store(AttachmentStoreRequest $request, $id)
    {

        if($request->hasFile('file')){

            $file = $request->file('file');
            // $path = Storage::store;
            $path = $file->store('filetracking/document/attachments');
        }

        $attachment = FTS_DA::create([
            'document_id' => $id,
            'employee_id' => authenticated()->employee_id,
            'name' => $request->post('name'), 
            'file'  => str_replace('filetracking/document/attachments/', '', $path) ?? null,
            'properties' => [
                'number'    => $request->post('number') ?? null, 
                'date'      => $request->post('date')   ?? null, 
                'amount'    => $request->post('amount') ?? null, 
                'page'      => $request->post('page')   ?? null, 
            ]
        ]);

        return response()->json([
            'message' => 'Attachment success'
        ]);
    }

    public function file($file)
    {
        return response()->file(storage_path('app/filetracking/document/attachments/'.$file));
    }
}
