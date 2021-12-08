<?php

namespace App\Http\Controllers;

use mikehaertl\pdftk\Pdf;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class DevController extends Controller
{
    public function __invoke(Request $request)
    {
        dd(\DocumentType::PROCUREMENT_PURCHASE_REQUEST->value);
    }
}
