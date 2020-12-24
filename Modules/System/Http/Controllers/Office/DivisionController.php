<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Http\Requests\Office\DivisionStoreRequest;
use Modules\System\Transformers\Office\DivisionResource;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            if($request->has('search')){
                $q = $request->get('search');
                $datas = SYS_Division::where('name', 'like', '%'.$q.'%')->orWhere('alias', 'like', '%'.$q.'%')->get();
            }else{
                $datas = SYS_Division::with('office')->get();
            }

            $datas = DivisionResource::collection($datas);
            return $datas;
        }
        return view('system::office.division.index');
        
    }

    public function store(DivisionStoreRequest $request)
    {
        $division = SYS_Division::create([
            'name' => $request->post('name'),
            'alias' => $request->post('alias'),
            'office_id' => $request->post('office')
        ]);

        return redirect(route('sys.office.division.index'))
                ->with('alert-success', 'Division has been created.');
    }
}
