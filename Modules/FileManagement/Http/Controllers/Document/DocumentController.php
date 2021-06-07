<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;
use Modules\FileManagement\Entities\Document\FMS_Tracking;

class DocumentController extends Controller
{
    public function index()
    {

        if(!authenticated()->can('fms.document.create')){
            return abort(403);
        }

        $documents = Document::with('latestTrack')
                                    ->where('division_id', authenticated()->employee->division_id)
                                    ->get(['id', 'created_at']);

        return view('filemanagement::documents.index', [
            'documents' => $documents,
            'total' => Document::where('division_id', authenticated()->employee->division_id)->count()
        ]);
    }

    public function receipt($id)
    {
        $document = Document::with('attachments', 'encoder', 'liaison', 'division.office')->findOrFail($id);
        
        require base_path()."/Modules/FileManagement/Includes/SwitchDocument.php";

        return view('filemanagement::documents.receipt', [
            'document' => $document,
            'datas' => $datas
        ]);
    }

    public function track(Request $request)
    {
        if($request->has('qr')){

            $id = series($request->get('qr'));
            $document = Document::with('attachments', 'encoder', 'liaison', 'division.office')->find($id);

            // checking if the qr code match
            if(!$document || $document->qr != $request->get('qr')){
                return redirect(route('fms.documents.track'))->with('alert-error', 'Document not found.');
            }

            require base_path()."/Modules/FileManagement/Includes/SwitchDocument.php";

            $tracks = FMS_Tracking::with('liaison', 'clerk', 'division.office')->where('document_id', $id)->orderBy('id', 'DESC')->get();

        }

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Track document'
        ]);
        

        return view('filemanagement::tracking.index', [
            'document'      => $document ?? null,
            'rel'           => $rel ?? null,
            'datas'         => $datas ?? [],
            'tracks'        => $tracks ?? null
        ]);

        
    }
}
