<?php

namespace Modules\FileTracking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Qr;

class QRController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){

            $qrs = FTS_Qr::where('status', false)->get();

            $records['data'] = array();

            foreach($qrs as $i => $qr){
                $records['data'][$i]['id'] = $qr->id;
                $records['data'][$i]['series'] = fts_series($qr->id);
            }

            return response()->json($records, 200);
        }


        return view('filetracking::qr.index');
    }

    public function generate(Request $request)
    {

        // check if too much available QR Code
        $check = FTS_Qr::where('status', false)->count();

        if($check > 1500){
            return redirect()->back()->with('alert-error', 'You already generated too much QR Codes');
        }


        $lists = array();

        $counts = (int)$request->post('counts');

        if($counts >= 1500 || $counts <= 0){
            return redirect()->back()->with('alert-error', 'Invalid QR Code counts');
        }

        for($count = 1; $count <= $counts; $count++){
            $lists[]['status'] = false;
        }


        FTS_Qr::insert($lists);

        return redirect()->back()->with('alert-success', 'QR Codes has been generated');
    }
}
