<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Transformers\Office\DivisionResource;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return DivisionResource::collection(SYS_Division::with('office')->lists(false));
        }
        return view('system::office.division.index');
        
    }
}
