<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\FMS_Document;

class ProcurementController extends Controller
{
    public function index()
    {
        if(request()->ajax()){

            $lists = array();

            $procurement_types = array_values(config('constants.document.type.procurement'));

            $procurements = Document::with(
                'purchase_request', 'purchase_order', 'cafoa', 'division.office'
            )->whereIn('type', $procurement_types)->get();

            foreach($procurements as $proc){

                switch($proc->type){
                    case config('constants.document.type.procurement.request'): 
                        $number         = $proc->purchase_request->number;
                        $particulars    = $proc->purchase_request->purpose;
                        $amount         = number_format(collect($proc->purchase_request->lists)->sum(function($row){
                                            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
                                            }), 2);
                        $view           = route('fms.procurement.request.show', $proc->purchase_request->id);
                        $type           = 'Purchase Request';
                        break;
                    case config('constants.document.type.procurement.order'): 
                        $number         = $proc->purchase_order->number;
                        $particulars    = $proc->purchase_order->particulars;
                        $amount         = number_format(collect($proc->purchase_order->lists)->sum(function($row){
                                            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
                                            }), 2);
                        $view           = route('fms.procurement.order.show', $proc->purchase_order->id);
                        $type           = 'Purchase Order';
                        break;
                    case config('constants.document.type.procurement.cafoa'): 
                            $number         = $proc->cafoa->number;
                            $particulars    = $proc->cafoa->particulars;
                            $amount         = number_format(collect($proc->cafoa->lists)->sum('amount'), 2);
                            $view           = route('fms.cafoa.show', $proc->cafoa->id);
                            $type           = 'Cafoa';
                            break;
                    default:
                        $number         = null;
                        $particulars    = null;
                        $amount         = null;
                        $view           = null;
                        $type           = null;
                        break;
                }


                array_push($lists, [
                    'id'            =>  $proc->id,
                    'qr'            =>  $proc->qr,
                    'encoded'       =>  Carbon::parse($proc->created_at)->format('Y-m-d h:i A'),
                    'number'        =>  $number,
                    'amount'        =>  $amount,
                    'particulars'   =>  $particulars,
                    'show'          =>  $view,
                    'type'          =>  $type,
                    'office'        =>  office_helper($proc->division)
                ]);
            }

            return response()->json(["data" => $lists]);
        }

        return view('filemanagement::forms.procurement.index');
    }
}
