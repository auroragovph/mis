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
                $records['data'][$i]['series'] = fts_series($qr->id, 'encode');
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

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to generate QR codes but failed. Reason: Already generated too much QR Codes.');

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
        activity('fts')->on(new FTS_Qr)->log('Generated '.$counts.' QR code');

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


        return view('filetracking::qr.print', [
            'pages' => $pages->chunk(70)
        ]);

    }
}
