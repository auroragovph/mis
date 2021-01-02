<?php

use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Procurement\FMS_PR;
use Modules\FileManagement\Entities\Travel\FMS_TO;

switch($document->type){

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

    default: 
        $datas[''] = null;
    break;

}