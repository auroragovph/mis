<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;

class ProcurementController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $lists = $this->_dt();
            return response()->json($lists);
        }

        return view('filemanagement::forms.procurement.index');
    }

    public function _dt()
    {
        $lists = array();

        $procurement_types = array_values(config('constants.document.type.procurement'));

        $procurements = Document::with(
            'purchase_request', 'purchase_order', 'division.office'
        )->whereIn('type', $procurement_types)->get();

        foreach ($procurements as $proc) {

            switch ($proc->type) {
                case config('constants.document.type.procurement.request'):
                    $number      = $proc->purchase_request->number;
                    $particulars = $proc->purchase_request->particulars;
                    $amount      = number_format($proc->purchase_request->total_amount, 2);
                    $view        = route('fms.procurement.request.show', $proc->purchase_request->id);
                    $type        = 'Purchase Request';
                    break;
                case config('constants.document.type.procurement.order'):
                    $number      = $proc->purchase_order->number;
                    $particulars = $proc->purchase_order->particulars;
                    $amount      = number_format($proc->purchase_order->total_amount, 2);
                    $view        = route('fms.procurement.order.show', $proc->purchase_order->id);
                    $type        = 'Purchase Order';
                    break;
                default:
                    $number      = null;
                    $particulars = null;
                    $amount      = null;
                    $view        = null;
                    $type        = null;
                    break;
            }

            array_push($lists, [
                '#'           => $proc->id,
                'QR Code'     => $proc->qrcode,
                'Number'      => $number,
                'Type'        => $type,
                'Particulars' => $particulars,
                'Amount'      => $amount,
                'Actions'     => '<a href="' . $view . '">View</a>',
            ]);
        }

        return $lists;

    }
}
