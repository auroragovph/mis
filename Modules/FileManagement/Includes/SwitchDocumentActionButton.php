<?php

switch($document->type){

    case config('constants.document.type.procurement.request'): //PURCHASE REQUEST
        break;
    case config('constants.document.type.procurement.order'): //PURCHASE ORDER
        break;
    default: 
        break;
}