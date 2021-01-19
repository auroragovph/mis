<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

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

    public function track()
    {
        if(request()->has('series')){

            $series = fts_series(request()->get('series'), 'decode');
            $document = FTS_Document::with('encoder', 'liaison', 'division.office')->where('series', $series)->first();

            if(!$document){
                return redirect()->back()->with('alert-error', 'Document not found.');
            }

            $tracks = FTS_Tracking::with('liaison', 'clerk', 'division.office')->where('document_id', $document->id)->orderBy('id', 'DESC')->get();


            require base_path()."/Modules/FileTracking/Includes/SwitchDocument.php";


            return view('filetracking::documents.track', [
                'document' => $document,
                'datas' => $datas,
                'tracks' => $tracks
            ]);
        }

        return view('filetracking::documents.track');
    }
}
