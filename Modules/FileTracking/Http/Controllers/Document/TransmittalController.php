<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Transmittal;

class TransmittalController extends Controller
{
    public function releaseIndex()
    {
        $transmittals = FTS_Transmittal::get();

        return view('filetracking::documents.transmittal.release.index', [
            'transmittals' => $transmittals
        ]);
    }

    public function releaseForm(Request $request)
    {
        $validQRS = [];

        $errors = [];

        $series = array_map(function($val){
            return fts_series($val);
        }, $request->post('qrs'));

        // GET ALL THE DOCUMENTS
        $documents = collect(FTS_Document::with('latestTrack')->whereIn('series', $series)->get()->toArray());


        $transmits = array();

        foreach($series as $i => $qr){
            $document = $documents->where('series', $qr)->first();
            $err['message'] = '';
            $err['code'] = '';

            // checking if the document is in the lists of documents
            if($document == null){
                
                $err['message'] = 'Document not found. ';
                $err['code'] = 404;

                $transmits[$i]['error'] = true;
                $transmits[$i]['message'] = 'Document not found';
                $transmits[$i]['document'] = [
                    'series' => fts_series($qr, 'encode'),
                    'status' => null,
                    'date' => null,
                    'type' => null,
                ];

                continue;
            }


            // checking document type
            if($document['status'] == 0){
                $err['message'] .= 'Document has been cancelled. ';
            }

            // checking if you currently receive the document
            if($document['latest_track']['division_id'] != auth()->user()->employee->division_id){
                $err['message'] .= 'Document currently received in another office/division. ';
            }

            if(!empty($err)){
                $message = 'Cannot include in transmittal. '.$err['message'];
            }

            $transmits[$i]['error'] = (empty($err['message'])) ? false : true;
            $transmits[$i]['message'] = (empty($err['message'])) ? 'Ready for transmittal' : $message;
            $transmits[$i]['document'] = [
                'series' => fts_series($qr, 'encode'),
                'date' => $document['created_at'],
                'status' => $document['status'],
                'type' => doc_type_only($document['type']),
            ];


            if(empty($err['message'])){
                $validQRS[] = $document['id'];
            }
        }


        // saving into sessions
        session()->push('fts.documents.transmittal', $validQRS);

        // dd(session('fts.documents.transmittal'));

        return view('filetracking::documents.transmittal.release.form', [
            'transmits' => $transmits
        ]);
    }

    public function releaseSubmit(Request $request)
    {

        $documents = session()->pull('fts.documents.transmittal');

        $transmittal = FTS_Transmittal::create([
            'documents' => $documents,
            'office->receiving' => $request->input('division')
        ]);


        dd($transmittal);

        return redirect(route('fts.documents.transmittal.release.index'))
                    ->with('alert-success', 'Transmittal has been registered.')
                    ->with('fts.transmittal.uuid', $transmittal->id);
    }

    public function releasePrint()
    {
        return view('filetracking::documents.transmittal.release.print');
    }

    public function receive()
    {
        return view('filetracking::documents.transmittal.receive.index');
    }
}
