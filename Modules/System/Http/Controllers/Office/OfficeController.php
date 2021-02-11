<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\SYS_Office;
use Modules\HumanResource\Entities\HR_Plantilla;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Transformers\Office\OfficeResource;
use Modules\System\Http\Requests\Office\OfficeStoreRequest;

class OfficeController extends Controller
{
    
    public function index()
    {
        if(request()->ajax()){
            if(request()->has('search')){
                $q = request()->get('search');
                $datas = SYS_Office::where('name', 'like', '%'.$q.'%')->orWhere('alias', 'like', '%'.$q.'%')->get();
            }else{
                $datas = SYS_Office::with('divisions')->get();
            }
            $datas = OfficeResource::collection($datas);
            return $datas;
        }

        return view('system::office.index');
    }

    public function store(OfficeStoreRequest $request)
    {
        $office = SYS_Office::create([
            "name" => $request->post('name'),
            "alias" => $request->post('alias'),
        ]);

        return redirect(route('sys.office.index'))->with('alert-success', 'Office has been created.');
    }


}
