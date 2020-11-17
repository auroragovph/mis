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

            // saving the activity logs
            activity('fts')
            ->on(new FTS_Document())
            ->withProperties(['agent' => user_agent()])
            ->log('Check the document if can attach number but failed. Reason: Series not found.');

            return redirect()->back()->with('alert-error', 'Series not found.');
        }

         // saving the activity logs
         activity('fts')
         ->on(new FTS_Document())
         ->withProperties(['agent' => user_agent()])
         ->log('Check the document if can attach number');

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


        // saving the activity logs
        activity('fts')
                ->on(new FTS_DA())
                ->withProperties(['agent' => user_agent()])
                ->log('Tries to attach number to the document');

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

        $attach = FTS_DA::insert($attachments);

        session()->flash('alert-success', 'Attachments success.');

        // saving the activity logs
        activity('fts')
                ->on(new FTS_DA())
                ->withProperties([
                    'document_id' => $id,
                    'agent' => user_agent()
                ])
                ->log('Successfully attach documents');

        return redirect(route('fts.documents.attach.form', [
            'id' => $id
        ]))->with('fts.documents.attach.cheked', true);
    }
}
