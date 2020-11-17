<?php

namespace Modules\HumanResource\Http\Controllers\Plantilla;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Plantilla;

class PositionController extends Controller
{
    public function index()
    {
        $positions = HR_Plantilla::with('salary_grade')->get();

        return view('humanresource::plantilla.position.index', [
            "positions" => $positions
        ]);
    }

    public function lists(Request $request)
    {
        if($request->ajax()){

            $datas = array();
            
            if($request->has('term') OR $request->post('term') != ''){
                $rows = HR_Plantilla::where('position', 'like', '%'.$request->post('term').'%')->get();
                foreach($rows as $row){
                    array_push($datas, [
                        'id' => $row->id,
                        'text' => $row->position
                    ]);
                }
                return response()->json($datas, 200);
            }

            array_push($datas, [
                'id' => 0,
                'text' => 'Search the position.',
                'disabled' => true
            ]);
            

            return response()->json($datas, 200);
        }
    }
}
