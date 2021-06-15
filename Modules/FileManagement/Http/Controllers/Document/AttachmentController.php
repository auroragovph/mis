<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.attach']);
    }

    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request document attach form.']);
        return view('filemanagement::documents.attach');
    }
}
