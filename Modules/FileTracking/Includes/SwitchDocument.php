<?php

use Modules\FileTracking\Entities\FTS_AFL;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;

switch($document->type){

    case config('constants.document.type.procurement.request'): // PURCHASE REQUEST
        $pr = FTS_PurchaseRequest::where('document_id', $document->id)->first();
        $datas['Number'] = $pr->number;
        $datas['Particulars'] = $pr->particulars;
        $datas['Amount'] = number_format(floatval($pr->amount), 2);
    break;

    case config('constants.document.type.cafoa'): //CAFOA
        $cafoa = FTS_Cafoa::where('document_id', $document->id)->first();
        $datas['Number'] = $cafoa->number;
        $datas['Particulars'] = $cafoa->particulars;
        $datas['Amount'] = number_format(floatval($cafoa->amount), 2);
        
    break;

    case config('constants.document.type.disbursement'): //DV
        $dv = FTS_DisbursementVoucher::where('document_id', $document->id)->first();
        $datas['Payee'] = $dv->payee;
        $datas['Particulars'] = $dv->particulars;
        $datas['Code'] = $dv->code;
        $datas['Accountable Person'] = $dv->accountable;
        $datas['Amount'] = number_format(floatval($dv->amount), 2);
    break;

    case config('constants.document.type.payroll'): //PAYROLL
        $payroll = FTS_Payroll::where('document_id', $document->id)->first();
        $datas['Name'] = $payroll->name;
        $datas['Particulars'] = $payroll->particulars;
        $datas['Amount'] = number_format(floatval($payroll->amount), 2);
    break;

    case config('constants.document.type.travel.itinerary'): //ITINERARY
        $iot = FTS_Itinerary::where('document_id', $document->id)->first();
        $datas['Name'] = $iot->name;
        $datas['Position'] = $iot->position;
        $datas['Destination'] = $iot->destination;
        $datas['Purpose'] = $iot->particulars;
        $datas['Amount'] = number_format(floatval($iot->amount), 2);
    break;

    case config('constants.document.type.afl'): //AFL
        $afl = FTS_AFL::where('document_id', $document->id)->first();

        $datas['Name'] = $afl->name;
        $datas['Position'] = $afl->position;
        $datas['Credits as of'] = $afl->credits;
        $datas['...hidden'] = [
            'vacation' => $afl->leave['vacation'],
            'sick' => $afl->leave['sick']
        ];

    break;

    

    

    default: 
        $datas[''] = null;
    break;

}