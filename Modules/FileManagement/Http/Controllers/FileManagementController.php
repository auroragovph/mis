<?php

namespace Modules\FileManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class FileManagementController extends Controller
{
    public function __invoke()
    {
        return view('filemanagement::index');
    }   
}
