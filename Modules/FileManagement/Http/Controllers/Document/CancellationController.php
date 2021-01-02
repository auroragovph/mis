<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Http\Requests\Document\CancellationRequest;

class CancellationController extends Controller
{
    public function index()
    {
        return view('filemanagement::documents.cancel');
    }

    public function check(CancellationRequest $request)
    {
        $document = FMS_Document::find(series($request->document));

        if(!$document || $document->qr != $request->post('document')){
            return redirect()->back()->with('alert-error', 'Document not found.');
        }

        return redirect(route('fms.documents.cancel.form', $document->id));
    }

    public function form(FMS_Document $id)
    {
        return view('filemanagement::documents.cancel', ['document' => $id]);
    }

    public function submit(CancellationRequest $request, $id)
    {
        $document = FMS_Document::findOrFail($id);
        $document->update([
            'status' => 0
        ]);

        return redirect(route('fms.documents.cancel.index'))->with('alert-success', 'Document has been cancelled.');
    }
}
