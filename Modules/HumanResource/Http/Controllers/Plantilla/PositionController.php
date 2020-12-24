<?php

namespace Modules\HumanResource\Http\Controllers\Plantilla;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Plantilla;
use Modules\HumanResource\Transformers\Plantilla\PositionResource;

class PositionController extends Controller
{
    public function lists(Request $request)
    {
        if($request->ajax()){

            $datas = array();
            
            if($request->has('search') OR $request->post('search') != ''){
                $datas = HR_Plantilla::where('position', 'like', '%'.$request->post('search').'%')->get();
            }else{
                $datas = HR_Plantilla::get();
            }

            return PositionResource::collection($datas);
        }
    }
}
