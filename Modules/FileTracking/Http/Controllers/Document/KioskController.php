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

                // saving the activity logs
                activity('fts')
                ->withProperties(['agent' => user_agent()])
                ->log('Try to track the document via kiosk but failed. Reason: Document not found.');

                return view('filetracking::documents.kiosk');
            }

        }

        // saving the activity logs
        activity('fts')
                ->withProperties([
                    'series' => $series,
                    'agent' => user_agent()
                ])
                ->log('Track the document via Kiosk');

        return view('filetracking::documents.kiosk', [
            'document' => $document['document'] ?? null,
        ]);
        
    }
}
