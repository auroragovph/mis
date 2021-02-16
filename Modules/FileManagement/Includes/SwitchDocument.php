<?php

use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Procurement\FMS_PO;
use Modules\FileManagement\Entities\Procurement\FMS_PR;
use Modules\FileManagement\Entities\Travel\FMS_IOT;
use Modules\FileManagement\Entities\Travel\FMS_TO;

switch($document->type){

    case config('constants.document.type.afl'): //AFL 
        $afl = FMS_AFL::with('employee')->where('document_id', $id)->first();
        $datas['Employee'] = name_helper($afl->employee->name);
        $datas['Credits'] = $afl->credits['as-of'];
        $datas['Type'] = $afl->properties['type'];

        $datas['...hidden']['vacation'] = $afl->credits['vacation'];
        $datas['...hidden']['sick']     = $afl->credits['sick'];

    break;

    case config('constants.document.type.procurement.request'): // PURCHASE REQUEST

        $pr = FMS_PR::with('requesting')->where('document_id', $id)->get()->first();

        $lists = collect($pr->lists);

        $datas['PR Number'] = $pr->number;
        $datas['Requesting Officer'] = name_helper($pr->requesting->name);
        $datas['Purpose'] = $pr->purpose;
        $datas['Fund'] = $pr->fund;
        $datas['FPP'] = $pr->fpp;
        $datas['Amount'] = number_format($lists->sum(function($row){
            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
        }), 2);

    break;

    case config('constants.document.type.procurement.order'): //PURCHASE ORDER
        $po = FMS_PO::where('document_id', $id)->first();
        $lists = collect($po->lists);

        $datas['PO Number'] = $po->number;
        $datas['Supplier']  = $po->supplier['firm'];
        $datas['Amount']  = number_format($lists->sum(function($row){
            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
        }), 2);

    break;

    case config('constants.document.type.cafoa'): 
        $cafoa = FMS_Cafoa::where('document_id', $id)->first();

        $datas['Number'] = $cafoa->number;
        $datas['Payee'] = $cafoa->payee;
        $datas['Amount'] = number_format(floatval(collect($cafoa->lists)->sum(function($row){
            return floatval($row['amount'] ?? 0);
        })), 2);

        break;

    case 200: //OBLIGATION REQUEST
        $obr = FMS_ObligationRequest::with('lists')->where('document_id', $id)->first();

        $datas['OBR Number'] = $obr->number;
        $datas['Payee'] = $obr->payee;
        $datas['Address'] = $obr->address;
        $datas['Amount'] = number_format($obr->lists->sum('amount'), 2);

    break;

    case 301: //TRAVEL ORDER
        $to = FMS_TO::with('lists.employee')->where('document_id', $id)->first();

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

    break;

    case config('constants.document.type.travel.itinerary'): 
        $iot = FMS_IOT::with('employee', 'head', 'supervisor')->where('document_id', $id)->first();

        $datas['Employee'] = name_helper($iot->employee->name);
        $datas['Number'] = $iot->number;
        $datas['Fund'] = $iot->fund;
        $datas['Date of Travel'] = $iot->travel_date;
        $datas['Purpose'] = $iot->travel_purpose;
    break;

    default: 
        $datas[''] = null;
    break;

}