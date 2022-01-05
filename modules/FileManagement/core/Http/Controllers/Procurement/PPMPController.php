<?php

namespace Modules\FileManagement\core\Http\Controllers\Procurement;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\core\Models\Procurement\PPMP;

class PPMPController extends Controller
{
    public function index()
    {
        $ppmps = PPMP::get()->toTree();

        return view('fms::procurement.ppmp.index', compact('ppmps'));
    }
}
