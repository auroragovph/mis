<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class KioskController extends DocumentController
{
    public function kiosk(Request $request)
    {
        if($request->has('series')){

            $series = fts_series($request->get('series'), 'decode');
            $document = collect($this->full($series, ['tracks', 'datas']));

            if($document->count() == 0){
                Session::flash('alert-error', 'Series not found!');
                return view('filetracking::documents.kiosk');
            }

        }

        return view('filetracking::documents.kiosk', [
            'document' => $document['document'] ?? null,
        ]);
        
    }
}
