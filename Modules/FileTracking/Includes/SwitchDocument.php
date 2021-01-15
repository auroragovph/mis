<?php

use Modules\FileTracking\Entities\FTS_Cafoa;

switch($document->type){

    case config('constants.document.type.procurement.request'): // PURCHASE REQUEST

       

    break;

    case config('constants.document.type.cafoa'): //CAFOA
        $cafoa = FTS_Cafoa::where('document_id', $document->id)->first();
        $datas['Number'] = $cafoa->number;
    break;

    default: 
        $datas[''] = null;
    break;

}