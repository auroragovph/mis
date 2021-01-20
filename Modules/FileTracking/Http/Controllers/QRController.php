<?php

namespace Modules\FileTracking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\FileTracking\Transformers\QRDTResource;

class QRController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            return response()->json(QRDTResource::collection(FTS_QR::available()));
        }

        return view('filetracking::qrcode.index');
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

        $lists = array();

        $timestamp = now();

        for($count = 1; $count <= $counts; $count++){
            array_push($lists, [
                'status' => false,
                'created_at' => $timestamp
            ]);
        }


        $qrs = FTS_Qr::insert($lists);

        // logging to the activity logs
        // activitylog()

        return redirect()->back()->with('alert-success', 'QR Codes has been generated');
    }
    
    public function print(Request $request)
    {
        $type = $request->post('type');

        if($type == 'auto'){
            if($request->post('driver') == 'last'){
                $qrs = range((int)$request->post('counts'), (int)$request->post('counts') + 699);
            }else{

                $losts = FTS_Qr::where('status', false)->take($request->post('counts'));
                $qrs = $losts->pluck('id');
            }
        }else{
            $qrs = range((int)$request->post('start'), (int)$request->post('end'));
        }

        $pages = collect($qrs);


        return view('filetracking::qrcode.print', [
            'pages' => $pages->chunk(70)
        ]);

    }

}
