<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\FMS_Document;

class DocumentController extends Controller
{
    public function index()
    {
        return view('filemanagement::documents.index');
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
}
