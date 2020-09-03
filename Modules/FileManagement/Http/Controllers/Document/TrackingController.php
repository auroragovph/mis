<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\FileManagement\Entities\FMS_Tracking;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Obr\FMS_ObligationRequest;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;

class TrackingController extends Controller
{
    public function track(Request $request)
    {
        $id = series_to_id($request->document);


        $document = FMS_Document::with('liaison', 'encoder', 'division.office')->find($id);

    
        if($document == null || !$document) {
            Session::flash('alert-error', 'Document not found!');
            return view('filemanagement::documents.track');
        }





        $datas['Requesting Office'] = office_helper($document->division);
        $datas['Liaison Officer'] = name_helper($document->liaison);
        $datas['Encoded By'] = name_helper($document->encoder);
        $datas['Encoded Date'] = Carbon::parse($document->created_at)->format('F d, Y h:i A');

        

        switch($document->type){

            case 101: // PURCHASE REQUEST
        
                $pr = FMS_PurchaseRequest::with('requesting', 'charging', 'lists')->where('document_id', $id)->get()->first();
        
                $datas['PR Number'] = $pr->number;
                $datas['Requesting Officer'] = name_helper($pr->requesting);
                $datas['Charging Officer'] = office_helper($pr->charging);
                $datas['Purpose'] = $pr->purpose;
                $datas['Amount'] = number_format($pr->lists->sum(function($row){return $row->qty * $row->cost;}),2);
        
            break;

            case 200: //OBLIGATION REQUEST
                $obr = FMS_ObligationRequest::with('lists')->where('document_id', $id)->first();

                $datas['OBR Number'] = $obr->number;
                $datas['Payee'] = $obr->payee;
                $datas['Address'] = $obr->address;
                $datas['Amount'] = number_format($obr->lists->sum('amount'), 2);

            break;

            case 301: //TRAVEL ORDER
                $to = FMS_TravelOrder::with('employees.employee')->where('document_id', $id)->first();

                $datas['TO Number'] = $to->number;
                $datas['Destination'] = $to->destination;
                $datas['Departure'] = $to->departure;
                $datas['Arrival'] = $to->arrival;
                $datas['Purpose'] = $to->purpose;

                $employees = '';

                foreach($to->employees as $employee){
                    $employees .= name_helper($employee->employee, 'FMIL').", ";
                }

                $datas['Employees'] = substr($employees, 0, -2);

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
