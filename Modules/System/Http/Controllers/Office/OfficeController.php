<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Http\Requests\Office\OfficeStoreRequest;
use Modules\System\Transformers\Office\OfficeResource;

class OfficeController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){


            if($request->has('search')){
                $q = $request->get('search');
                $datas = SYS_Office::where('name', $q)->orWhere('alias', $q)->get();
                
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
            "name" => $request->name,
            "alias" => $request->alias,
        ]);

        $division = SYS_Division::create([
            "office_id" => $office->id
        ]);

        return redirect(route('sys.office.index'))->with('alert-success', 'Office has been created.');
    }


}
