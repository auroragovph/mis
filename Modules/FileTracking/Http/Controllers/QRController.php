<?php

namespace Modules\FileTracking\Http\Controllers;

use Illuminate\Routing\Controller;

class QRController extends Controller
{
    public function index()
    {
        return view('filetracking::qrcode.index');
    }
}
