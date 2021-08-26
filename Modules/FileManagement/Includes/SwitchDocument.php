<?php

use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\FileManagement\Entities\Cafoa\Cafoa;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;
use Modules\FileManagement\Entities\Procurement\PurchaseRequest;
use Modules\FileManagement\Entities\Travel\FMS_IOT;
use Modules\FileManagement\Entities\Travel\FMS_TO;
use Modules\FileManagement\Entities\Travel\TravelOrder;

switch($document->type){

    case config('constants.document.type.afl'): //AFL 
        $afl = FMS_AFL::with('employee')->where('document_id', $id)->first();
        $datas['Employee'] = name_helper($afl->employee->name);
        $datas['Credits'] = $afl->credits['as-of'];
        $datas['Type'] = $afl->properties['type'];

        $datas['...hidden']['vacation'] = $afl->credits['vacation'];
        $datas['...hidden']['sick']     = $afl->credits['sick'];

        $rel = $afl;


        break;

    case config('constants.document.type.procurement.request'): // PURCHASE REQUEST

        $pr = PurchaseRequest::where('document_id', $id)->get()->first();

        $lists = collect($pr->lists);

        $datas['PR Number'] = $pr->number;
        $datas['Fund'] = $pr->fund;
        $datas['Amount'] = number_format($lists->sum(function($row){
            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
        }), 2);

        $datas['Purpose'] = $pr->purpose;
        $datas['Particulars'] = $pr->particulars;


        $rel = $pr;
        break;

    case config('constants.document.type.procurement.order'): //PURCHASE ORDER
        $po = PurchaseOrder::with('supplier_rel')->where('document_id', $id)->first();
        $lists = collect($po->lists);

        $datas['PO Number'] = $po->number;
        $datas['Supplier']  = $po->supplier_rel->name;
        $datas['Amount']  = number_format($lists->sum(function($row){
            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
        }), 2);
        $rel = $po;

        break;

    
    
    case config('constants.document.type.procurement.cafoa'): // PURCHASE PROCUREMENT CAFOA
    case config('constants.document.type.cafoa'): 
        $cafoa = Cafoa::where('document_id', $id)->first();

        $datas['Number'] = $cafoa->number;
        $datas['Payee'] = $cafoa->payee;
        $datas['Amount'] = number_format(floatval(collect($cafoa->lists)->sum(function($row){
            return floatval($row['amount'] ?? 0);
        })), 2);
        $rel = $cafoa;

        break;


    case config('constants.document.type.travel.order'): //TRAVEL ORDER
        $to = TravelOrder::with('lists.employee')->where('document_id', $id)->first();

        $datas['TO Number'] = $to->number;
        $datas['Destination'] = $to->destination;
        $datas['Departure'] = $to->departure;
        $datas['Arrival'] = $to->arrival;
        $datas['Purpose'] = $to->purpose;

        $employees = '';

        foreach($to->lists as $list){
            $employees .= name_helper($list->employee->name).", ";
        }

        $datas['Employees'] = substr($employees, 0, -2);
        $rel = $to;

        break;

    case config('constants.document.type.travel.itinerary'): 
        $iot = FMS_IOT::with('employee', 'head', 'supervisor')->where('document_id', $id)->first();

        $datas['Employee'] = name_helper($iot->employee->name);
        $datas['Number'] = $iot->number;
        $datas['Fund'] = $iot->fund;
        $datas['Date of Travel'] = $iot->travel_date;
        $datas['Purpose'] = $iot->travel_purpose;
        $rel = $iot;
        break;

    default: 
        $datas[''] = null;
        $rel = null;

        break;

}