<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class TransmittalController extends Controller
{
    public function releaseIndex()
    {
        dd(Str::uuid());
    }

    public function receive()
    {
        return view('filetracking::documents.transmittal.receive.index');
    }
}
