<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\FileManagement\Entities\FMS_Tracking;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Travel\FMS_TravelOrder;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Obr\FMS_ObligationRequest;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseRequest;
use Modules\HumanResource\Entities\HR_Employee;

class RRController extends Controller
{
    public function index()
    {
        // dd(Auth::user()->employee->division);
        return view('filemanagement::documents.rr');
    }

    public function form(Request $request)
    {
        // converting DOCUMENT QR
        $id = series($request->document);

        $document = FMS_Document::with('encoder', 'liaison', 'division.office')->find($id);

        // checking if document exists
        if($document == null){
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'We cannot find this document. Please check the document id or the QR COde and try again.');
        }

        // check if document is not cancelled
        if($document->status == 0){
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'The document has been cancelled.');
        }

        // check if document is activated
        if($document->status == 1){
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'Please activate the document first.');
        }



        // converting LIAISON QR TO ID
        $lid = employee_id_helper($request->liaison);
        $liaison = HR_Employee::whereIdCard($lid)->first();

        // checking if the liaison exists
        if($liaison == null){
            return redirect(route('fms.documents.rr.index'))->with('alert-error', 'The liaison officer not found.');
        }


        $track = FMS_Tracking::with('division.office')->where('document_id', $id)->orderBy('created_at', 'DESC')->first();

        // check if you can receive this paper
        //if the document is currently receive
        if($track->action == 1){
            // check if the document is receive in your division/office
            if($track->division_id != Auth::user()->employee->division_id){
                $office = office_helper($track->division);
                return redirect(route('fms.documents.rr.index'))->with('alert-error', "This document current receive at <b> {$office} </b>. Please release the document first and try again!");
            }
        }

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
                    $employees .= name_helper($employee->employee->name).", ";
                }

                $datas['Employees'] = substr($employees, 0, -2);

            break;
        
            default: 
                $datas[''] = null;
            break;
        
        }

        // setting session id 
        session(['fms.document.edit' => $id]);
        session(['fms.document.liaison' => $liaison->id]);
        ($track->action == 0) ? session(['fms.document.track' => 1]) : session(['fms.document.track' => 0]);

         // logging
         FMS_DocumentLog::log($document->id, 'Request to receive/release the document');

        return view('filemanagement::documents.rr', [
            'document' => $document,
            'datas' => $datas,
            'track' => $track
        ]);
    }

    public function submit(Request $request)
    {

        
        $id = session()->pull('fms.document.edit');
        $liaison = session()->pull('fms.document.liaison');
        $action = session()->pull('fms.document.track');
        $track = FMS_Tracking::log($id, $action, $request->purpose, $request->status, $liaison);
        ($action == 0) ? $acm = 'Document has been release.' : $acm = 'Document has been receive.' ;
        // logging
        FMS_DocumentLog::log($id, $acm);
        return redirect(route('fms.documents.rr.index'))->with('alert-success', $acm);

    }
}
