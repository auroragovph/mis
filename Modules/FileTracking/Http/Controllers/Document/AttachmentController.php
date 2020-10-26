<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Document;

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
            abort(404);
        }

        return view('filetracking::documents.attachment', [
            'document' => $document
        ]);
    }
}
