<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Document;

class AttachmentController extends DocumentController
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
            return redirect()->back()->with('alert-error', 'Series not found.');
        }

        return redirect(route('fts.documents.attach.form', [
            'id' => $document->id
        ]))->with('fts.documents.attach.cheked', true);
    }

    public function form($series)
    {
        // if(session()->has('fts.documents.attach.cheked') == false){
        //     return abort(404);
        // }

        $document = $this->full($series, ['datas', 'attachments']);
        $attachments = FTS_DA::lists();

        return view('filetracking::documents.attachment', [
            'document' => $document['document'],
            'attachments' => $attachments
        ]);

        // in_array()
    }

    public function store(Request $request, $id)
    {
        $attach = FTS_DA::where('document_id', $id)->delete();

        $attachments = array();
        foreach($request->post('tags') as $i => $attachment){
            $attachments[$i]['document_id'] = $id;
            $attachments[$i]['employee_id'] = auth()->user()->employee_id;
            $attachments[$i]['description'] = $attachment;
            $i++;
        }

        FTS_DA::insert($attachments);

        session()->flash('alert-success', 'Attachments success.');

        return redirect(route('fts.documents.attach.form', [
            'id' => $id
        ]))->with('fts.documents.attach.cheked', true);
    }
}
