<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Document;

class DocumentController extends Controller
{
    public function index()
    {
        return view('filetracking::documents.index');
    }

    

    public function receipt(Request $request)
    {
        if(!authenticated()->can('fts.document.print')){return abort(403);}

        $series = fts_series($request->get('series'), 'decode');
        $document = FTS_Document::with('encoder', 'liaison', 'division.office')->where('series', $series)->firstOrFail();
        
        require base_path()."/Modules/FileTracking/Includes/SwitchDocument.php";

        return view('filetracking::documents.receipt', [
            'document' => $document,
            'datas' => $datas
        ]);
    }
}
