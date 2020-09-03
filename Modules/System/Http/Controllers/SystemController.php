<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\SYS_Office;
use Modules\System\Entities\Office\SYS_Division;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // return view('system::index');

        // abort(500);
    }

    public function office_add()
    {
        // return view('system::index');


        $array['office'] = array();
        $array['division'] = array();

        for ($x = 1; $x <= 20; $x++) {


            $office['name'] = 'OFFICE-'.str_pad($x, 3, 0, STR_PAD_LEFT);
            $office['alias'] = 'OF-'.str_pad($x, 3, 0, STR_PAD_LEFT);


            $division['name'] = 'MAIN';
            $division['alias'] = 'MAIN';
            $division['office_id'] = $x;


            $array['office'][] = $office;
            $array['division'][] = $division;

        } 

        $a[0] = SYS_Office::insert($array['office']);
        $a[1] = SYS_Division::insert($array['division']);


        return response()->json($a, 200);


    }

}
