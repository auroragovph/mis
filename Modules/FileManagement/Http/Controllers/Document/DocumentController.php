<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_Tracking;

class DocumentController extends Controller
{
    public function index()
    {

        if(!authenticated()->can('fms.document.create')){
            return abort(403);
        }

        $documents = FMS_Document::with('latestTrack')
                                    ->where('division_id', authenticated()->employee->division_id)
                                    ->get(['id', 'created_at']);

        return view('filemanagement::documents.index', [
            'documents' => $documents,
            'total' => FMS_Document::where('division_id', authenticated()->employee->division_id)->count()
        ]);
    }

    public function receipt($id)
    {
        $document = FMS_Document::with('attachments', 'encoder', 'liaison', 'division.office')->findOrFail($id);
        
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
            $document = FMS_Document::with('attachments', 'encoder', 'liaison', 'division.office')->find($id);

            // checking if the qr code match
            if(!$document || $document->qr != $request->get('qr')){
                return redirect()->back()->with('alert-error', 'Document not found.');
            }

            require base_path()."/Modules/FileManagement/Includes/SwitchDocument.php";

            $tracks = FMS_Tracking::with('liaison', 'clerk', 'division.office')->where('document_id', $id)->orderBy('id', 'DESC')->get();

        }

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Track document'
        ]);
        

        return view('filemanagement::documents.track', [
            'document' => $document ?? null,
            'datas' => $datas ?? [],
            'tracks' => $tracks ?? null
        ]);

        
    }
}
