<?php

use Modules\FileManagement\Entities\Travel\FMS_TO;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Procurement\FMS_PR;

switch($document->type){

    case config('constants.document.type.procurement.request'): //PURCHASE REQUEST

        // check if already have a number
        $pr = FMS_PR::where('document_id', $id)->get()->first();

        if($pr->number == null){
            $data = FMS_PR::where('number', '!=', null)->orderBy('id', 'DESC')->get()->first();
            $last = ($data !== null) ? $data->number : 'EMPTY' ;
            $response['data']['type'] = 'LAST PR NUMBER';
            $response['data']['last'] = $last;

            $response['data']['meta']['type'] = $document->type;
            $response['data']['meta']['id'] = $pr->id;


        }else{
            $response['status'] = 406;
            $response['message'] = 'This document has already numbered.';
        }
        
    break;

    case config('constants.document.type.travel.order'): //TRAVEL ORDER
        $to = FMS_TO::where('document_id', $id)->first();

        if($to->number == null){
            $data = FMS_TO::where('number', '!=', null)->orderBy('id', 'DESC')->first();
            $last = ($data !== null) ? $data->number : 'EMPTY' ;
            $response['data']['type'] = 'LAST TO NUMBER';
            $response['data']['last'] = $last;

            $response['data']['meta']['type'] = $document->type;
            $response['data']['meta']['id'] = $to->id;
        }else{
            $response['status'] = 406;
            $response['message'] = 'This document has already numbered.';
        }
    break;

    case config('constants.document.type.procurement.cafoa'): // PROCUREMENT CAFOA
    case config('constants.document.type.cafoa'): // CAFOA
        $cafoa = FMS_Cafoa::where('document_id', $id)->first();

        if($cafoa->number == null){
            $data = FMS_Cafoa::where('number', '!=', null)->orderBy('id', 'DESC')->first();
            $last = ($data !== null) ? $data->number : 'EMPTY' ;
            $response['data']['type'] = 'LAST CAFOA NUMBER';
            $response['data']['last'] = $last;

            $response['data']['meta']['type'] = $document->type;
            $response['data']['meta']['id'] = $cafoa->id;
        }else{
            $response['status'] = 406;
            $response['message'] = 'This document has already numbered.';
        }
    break;
    
    default: 
        $response['status'] = 406;
        $response['message'] = 'You cannot attach number to this document';
    break;
}