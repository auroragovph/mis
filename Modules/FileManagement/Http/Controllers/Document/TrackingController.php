<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\FileManagement\Entities\AFL\FMS_AFL;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\FMS_Tracking;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;
use Modules\FileManagement\Entities\Travel\FMS_Itinerary;

class TrackingController extends Controller
{
    public function track(Request $request)
    {
        $id = series($request->document);


        $document = FMS_Document::with('liaison', 'encoder', 'division.office')->find($id);

    
        if($document == null || !$document || $request->document != $document->qr) {
            Session::flash('alert-error', 'Document not found!');
            return view('filemanagement::documents.track');
        }

        switch($document->type){

            case 101: // PURCHASE REQUEST
        
                $pr = FMS_PurchaseRequest::with('requesting')
                            ->where('document_id', $id)
                            ->first();
        
                $datas['PR Number'] = $pr->number;
                $datas['Requesting Officer'] = name_helper($pr->requesting->name);
                $datas['Purpose'] = $pr->purpose;
                $datas['Amount'] = number_format($pr->lists->sum(function($row){return $row['qty'] * $row['cost'];}),2);
        
            break;

            
            case 301: //TRAVEL ORDER
                $to = FMS_TravelOrder::with('employees')->where('document_id', $id)->first();

                $datas['TO Number'] = $to->number;
                $datas['Destination'] = $to->destination;
                $datas['Departure'] = $to->departure;
                $datas['Arrival'] = $to->arrival;
                $datas['Purpose'] = $to->purpose;

                $employees = '';

                foreach($to->employees as $employee){
                    $employees .= name_helper($employee->name).", ";
                }

                $datas['Employees'] = substr($employees, 0, -2);

            break;

            case 302: // ITINERARY OF TRAVEL
                $itinerary = FMS_Itinerary::with('employee')->where('document_id', $id)->first();

                $datas['Employee'] = name_helper($itinerary->employee->name);
                $datas['Number'] = $itinerary->number;
                $datas['Amount'] = collect($itinerary->list)->sum('amount');
            break;

            case 400: //CAFOA
                $cafoa = FMS_Cafoa::where('document_id', $id)->first();

                $datas['CAFOA Number'] = $cafoa->number;
                $datas['Payee'] = $cafoa->payee;
                $datas['Amount'] = number_format($cafoa->lists->sum('amount'), 2);

            break;

            case 500: //APPLICATION FOR LEAVE
                $afl = FMS_AFL::with('employee')->where('document_id', $id)->first();

                $datas['Employee'] = name_helper($afl->employee->name);

                if($afl->properties['type'] == 'Others'){
                    $datas['Type'] = $afl->properties['details'];
                }else{
                    $datas['Type'] = $afl->properties['type'];
                }


            break;

        
            default: 
                $datas[''] = null;
            break;
        
        }


        

        $tracks = FMS_Tracking::with('liaison', 'clerk', 'division.office')->where('document_id', $id)->orderBy('id', 'DESC')->get();



        // dd($datas);

        // logging
        FMS_DocumentLog::log($document->id, 'Tracked the document.');


        Session::forget('alert-error');

        return view('filemanagement::documents.track',[
            'document' => $document,
            'tracks' => $tracks,
            'datas' => $datas
        ]);
    }
}
