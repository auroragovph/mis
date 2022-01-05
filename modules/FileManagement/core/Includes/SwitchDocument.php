<?php

use Modules\FileManagement\core\Enums\Document\Type as Doctype;

switch ($document->type) {

    case Doctype::PROCUREMENT_PURCHASE_REQUEST->value:

        $pr                   = \Modules\FileManagement\core\Models\Procurement\PurchaseRequest::where('series_id', $id)->first();
        $datas['PR Number']   = $pr->number;
        $datas['Fund']        = $pr->fund;
        $datas['Amount']      = $pr->total_amount;
        $datas['Purpose']     = $pr->purpose;
        $datas['Particulars'] = $pr->particulars;

        $rel = $pr;
        break;

    default:
        $datas[''] = null;
        $rel       = null;

        break;

}
