<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;
use Modules\FileManagement\Entities\Document\Tracking;

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

        return view('filemanagement::document.index', [
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
}
