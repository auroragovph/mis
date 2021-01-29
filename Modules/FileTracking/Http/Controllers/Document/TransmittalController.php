<?php

namespace Modules\FileTracking\Http\Controllers\Document;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Document\FTS_Transmittal;

class TransmittalController extends Controller
{
    public function index()
    {
        $transmits = FTS_Transmittal::with('documentsInfo', 'receivingOffice')->latest()->take(10)->get();


        return view('filetracking::documents.transmittal.index', [
            'transmits' => $transmits
        ]);
    }

    public function form(Request $request)
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

            if($document['latest_track'] != null || !empty($document['latest_track'])){
                // checking if you currently receive the document
                if($document['latest_track']['division_id'] != authenticated()->employee->division_id){
                    $err['message'] .= 'Document currently received in another office/division. ';
                }
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

        // dd($transmits);

        return view('filetracking::documents.transmittal.form', [
            'transmits' => collect($transmits),
            'divisions' => SYS_Division::with('office')->get()
        ]);
    }

    public function form2(Request $request)
    {
        $transmittal = FTS_Transmittal::with('documentsInfo')->find($request->post('transmittal'));

        // checking if the transmittal exists
        if(!$transmittal){
            return redirect()->back()->with('alert-error', 'Transmittal not found.');
        }

        // checking if the transmittal is already receive
        if($transmittal->status == 2){
            return redirect()->back()->with('alert-error', 'Transmittal already received.');
        }

        // checking if the transmittal is expired
        if($transmittal->status == 3 || $transmittal->isExpired == true){

            if($transmittal->status == 1){
                $transmittal->status = 3;
                $transmittal->save();
            }

            return redirect()->back()->with('alert-error', 'Transmittal was expired.');
        }

        // checking if you can receive the transmittal report
        if($transmittal['receiving_office'] != authenticated()->employee->division_id){
            return redirect()->back()->with('alert-error', 'You cannot receive this transmittal.');
        }

        // converting LIAISON QR TO ID
        $lid = employee_id_helper($request->post('liaison'));
        $liaison = HR_Employee::whereIdCard($lid)->first();

        // checking if the liaison exists
        if($liaison == null){
           
            return redirect()->back()->with('alert-error', 'The liaison officer not found.');
        }

        // saving into sessions
        session()->push('fts.documents.transmittal', $transmittal->id);
        session()->push('fts.documents.liaison', $liaison->id);


        return view('filetracking::documents.transmittal.receive',[
            'transmittal' => $transmittal
        ]);
    }

    public function release(Request $request)
    {
        $documents = session()->pull('fts.documents.transmittal');

        $transmittal = FTS_Transmittal::create([

            'documents' => $documents[0],

            'receiving_office'      =>  $request->input('division'),
            'receiving_employee'    =>  null,
            'releasing_office'      => authenticated()->employee->division_id,
            'releasing_employee'    => authenticated()->employee_id
        ]);

        return redirect(route('fts.documents.transmittal.index'))
                    ->with('alert-success', 'Transmittal has been registered.')
                    ->with('fts.transmittal.uuid', route('fts.documents.transmittal.print', $transmittal->id));
    }

    public function receive(Request $request)
    {
        $transmittal_id = session()->pull('fts.documents.transmittal')[0] ?? 0;
        $transmittal = FTS_Transmittal::find($transmittal_id);

        $liaison = session()->pull('fts.documents.liaison')[0] ?? 0;

        // checking if the transmittal exists
        if(!$transmittal){
            return redirect(route('fts.documents.transmittal.index'))->with('alert-error', 'Transmittal not found.');
        }

        // checking if the transmittal is already receive
        if($transmittal->status == 2){
            return redirect(route('fts.documents.transmittal.index'))->with('alert-error', 'Transmittal already received.');
        }

        // checking if the transmittal is expired
        if($transmittal->status == 3 || $transmittal->isExpired == true){
            if($transmittal->status == 1){
                $transmittal->status = 3;
                $transmittal->save();
            }
            return redirect(route('fts.documents.transmittal.index'))->with('alert-error', 'Transmittal was expired.');
        }


        $tracks = array();
        $now = Carbon::now();

        foreach($transmittal->documents as $key => $document){
            $tracks[$key] = [

                'document_id' => $document,
                'action' => 1,
                'purpose' => $request->post('purpose'),
                'status' => $request->post('status'),
                'division_id' => authenticated()->employee->division_id,
                'liaison_id' => $liaison,
                'user_id' => authenticated()->employee_id,
                'created_at' => $now,
                'updated_at' => $now

            ];
        }

        // inserting into tracks
        FTS_Tracking::insert($tracks);

        // updating transmittal
        $transmittal->update([
            'status' => 2,
            'receiving_employee' => authenticated()->employee_id
        ]);

        return redirect(route('fts.documents.transmittal.index'))->with('alert-success', 'Transmittal has been received.');
    }

    public function print($uuid)
    {
        $transmittal = FTS_Transmittal::with('releasingOffice', 'receivingOffice', 'documentsInfo')->find($uuid);

        return view('filetracking::documents.transmittal.print', [
            'transmittal' => $transmittal
        ]);
    }
}
