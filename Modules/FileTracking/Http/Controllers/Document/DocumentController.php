<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class DocumentController extends Controller
{
    public function index()
    {
        return view('filetracking::documents.index');
    }

    public function receipt(Request $request)
    {
        $series = fts_series($request->get('series'), 'decode');


        $document = FTS_Document::with(
            'encoder', 
            'liaison',
            'division.office',
            'purchase_request'
        )->where('series', $series)->first();

        if(!$document){
            return abort(404);
        }

        $datas = array();

        switch($document->type){
            case 101: //PURCHASE REQUEST
                $pr = FTS_PurchaseRequest::where('document_id', $document->id)->first();
                $datas['PR Number'] = $pr->number;
                $datas['Date'] = $pr->date;
                $datas['Particular'] = $pr->particular;
                $datas['Purpose'] = $pr->purpose;
                $datas['Charging'] = $pr->charging;
                $datas['Accountable'] = $pr->accountable;
                $datas['Amount'] = $pr->amount;
            break;
        }

        
        
        return view('filetracking::documents.receipt', [
            'document' => $document,
            'datas' => $datas
        ]);
    }

    public function track(Request $request)
    {
        $series = fts_series($request->get('series'), 'decode');

        $document = FTS_Document::with(
            'encoder', 
            'liaison',
            'division.office'
        )->where('series', $series)->first();

        if(!$document){
            Session::flash('alert-error', 'Series not found!');
            return view('filetracking::documents.track');
        }

        $datas = array();

        switch($document->type){
            case 101: //PURCHASE REQUEST
                $pr = FTS_PurchaseRequest::where('document_id', $document->id)->first();
                $datas['PR Number'] = $pr->number;
                $datas['Date'] = $pr->date;
                $datas['Particular'] = $pr->particular;
                $datas['Purpose'] = $pr->purpose;
                $datas['Charging'] = $pr->charging;
                $datas['Accountable'] = $pr->accountable;
                $datas['Amount'] = $pr->amount;
            break;
        }

        $tracks = FTS_Tracking::with('liaison', 'clerk', 'division.office')->where('document_id', $document->id)->orderBy('id', 'DESC')->get();


        return view('filetracking::documents.track', [
            'document' => $document,
            'datas' => $datas,
            'tracks' => $tracks
        ]);

    }
}
