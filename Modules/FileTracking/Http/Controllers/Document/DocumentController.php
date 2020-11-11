<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;

class DocumentController extends Controller
{
    public function full($series, $includes = array())
    {
        $series = fts_series($series);

        $document = FTS_Document::with(
            'encoder',
            'liaison',
            'division.office'
        )->where('series', $series)->first();

        if(!$document){
            return null;
        }

        $record = [
            'document' => [

                'info' => [

                    'id' => $document->id,

                    'series' => [
                        'id' => $document->series,
                        'full' => $document->seriesFull
                    ],

                    'type' => [
                        'id' => $document->type,
                        'full' => $document->typeFull
                    ],

                    'status' => [
                        'id' => $document->status,
                        'dom' => show_status($document->status)
                    ],

                    'office' => [
                        'full' => office_helper($document->division) ?? '',
                        'alias' => office_helper($document->division, 'alias') ?? '',
                    ],

                    'encoded' => [
                        'timestamp' => $document->created_at,
                        'nicedate' => $document->encoded,
                    ],

                    'encoder' => [
                        'id' => $document->encoder->id ?? '',
                        'name' => $document->encoder->name ?? '',
                        'full' => name_helper($document->encoder->name ?? ''),
                    ],
                    
                    'liaison' => [
                        'id' => $document->liaison->id ?? '',
                        'name' => $document->liaison->name ?? '',
                        'full' => name_helper($document->liaison->name ?? ''),
                    ]

                ]
            ]
        ];

        if(in_array('attachments', $includes)){
            $attachments = FTS_DA::where('document_id', $document->id)->get()->toArray();
            $record['document']['attachments'] = $attachments;
        }

        if(in_array('datas', $includes)){
            $datas = array();

            switch($document->type){

                case config('constants.document.type.procurement.request'): //PURCHASE REQUEST
                    $pr = FTS_PurchaseRequest::where('document_id', $document->id)->first();
                    if(!$pr){break;}

                    $datas['PR Number'] = $pr->number;
                    $datas['Date'] = $pr->date;
                    $datas['Particular'] = $pr->particular;
                    $datas['Purpose'] = $pr->purpose;
                    $datas['Charging'] = $pr->charging;
                    $datas['Accountable'] = $pr->accountable;
                    $datas['Amount'] = number_format($pr->amount);
                break;

                case config('constants.document.type.travel.order'):  //TRAVEL ORDER
                    $to = FTS_TravelOrder::where('document_id', $document->id)->first();
                    if(!$to){break;}
                
                    $datas['TO Number'] = $to->number;
                    $datas['Employees'] = implode(', ', $to->employees);
                    $datas['Destination'] = $to->destination;
                    $datas['Departure'] = $to->departure;
                    $datas['Arrival'] = $to->arrival;
                    $datas['Purpose'] = $to->purpose;
                break;

                case config('constants.document.type.afl'): //AFL
                    $afl = FTS_AFL::where('document_id', $document->id)->first();
                    if(!$afl){break;}

                    $datas['Name'] = $afl->name;
                    $datas['Position'] = $afl->position;
                    $datas['Type'] = $afl->type;
                    $datas['Credits'] = $afl->credits;

                    $record['document']['..hidden'] = $afl->leave;

                break;

                case 302: // ITINERARY OF TRAVEL
                    $itinerary = FTS_Itinerary::where('document_id', $document->id)->first();
                    if(!$itinerary){break;}

                    $datas['Name'] = $itinerary->name;
                    $datas['Position'] = $itinerary->position;
                    $datas['Destination'] = $itinerary->destination;
                    $datas['Amount'] = $itinerary->amount;
                    $datas['Purpose'] = $itinerary->purpose;
                break;

                case 400: //CAFOA / OBR
                    $cafoa = FTS_Cafoa::where('document_id', $document->id)->first();
                    if(!$cafoa){break;}

                    $datas['Number'] = $cafoa->number;
                    $datas['Payee'] = $cafoa->payee;
                    $datas['Amount'] = number_format($cafoa->amount);
                    $datas['Particulars'] = $cafoa->particulars;
                break;

                case 600: //DISBURSEMENT VOUCHER
                    $dv = FTS_DisbursementVoucher::where('document_id', $document->id)->first();
                    if(!$dv){break;}

                    $datas['Payee'] = $dv->payee;
                    $datas['Amount'] = number_format($dv->amount);
                    $datas['Particulars'] = $dv->particulars;
                    $datas['Code'] = $dv->code;
                    $datas['Accountable Person'] = $dv->accountable;
                break;

                case 700: //PAYROLL
                    $payroll = FTS_Payroll::where('document_id', $document->id)->first();
                    if(!$payroll){break;}
                    
                    $datas['Name'] = $payroll->name;
                    $datas['Amount'] = number_format($payroll->amount, 2);
                    $datas['Particulars'] = $payroll->particulars;
                break;

            }
            $record['document']['datas'] = $datas;
        }


        if(in_array('tracks', $includes)){
            $tracks = FTS_Tracking::with('liaison', 'clerk', 'division.office')
                                        ->where('document_id', $document->id)
                                        ->orderBy('created_at', 'DESC')
                                        ->get();
            $record['document']['tracks'] = $tracks->toArray();
        }

        return $record;
    }

    public function index()
    {
        return view('filetracking::documents.index');
    }

    public function receipt(Request $request)
    {
        if(!auth()->user()->can('fts.document.print')){return abort(403);}

        $series = fts_series($request->get('series'), 'decode');

        $document = $this->full($series, ['datas', 'attachments']);

        if(!$document){
            return abort(404);
        }

        // dd($document);

      
        
        return view('filetracking::documents.receipt', [
            'document' => $document['document'],
        ]);
    }

    public function track(Request $request)
    {
        $series = fts_series($request->get('series'), 'decode');

        $document = collect($this->full($series, ['tracks', 'datas']));

        if($document->count() == 0){
            Session::flash('alert-error', 'Series not found!');
            return view('filetracking::documents.track');
        }

        return view('filetracking::documents.track', [
            'document' => $document['document'],
        ]);

    }

}
