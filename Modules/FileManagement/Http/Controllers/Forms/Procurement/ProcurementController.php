<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\FMS_Document;


class ProcurementController extends Controller
{
    public function index()
    {
        return view('filemanagement::form-procurement.index');
    }

    public function lists()
    {

        $documents = FMS_Document::with('purchase_request.lists')->whereIn('type', [101, 102])->where('division_id', Auth::user()->employee->division_id)->get();

        $response = array('data' => []);

        foreach($documents as $document){

            if($document->type == 101){
                $type = 'Purchase Request';
                $amount = (string)number_format($document->purchase_request->lists->sum(function($arr){return $arr->qty * $arr->cost;}), 2);
            }else{
                $type = 'Purchase Order';
            }




            $response['data'][] = array(
                'id' => $document->id,
                'did' => convert_to_series($document),
                'status' => $document->status,
                'amount' => $amount,
                'type' => $type,
                'encoded' => Carbon::parse($document->created_at)->format('F d, Y h:i A'),
                'actions' => ''

            );
        }

        return response()->json($response, 200);

    }
}
