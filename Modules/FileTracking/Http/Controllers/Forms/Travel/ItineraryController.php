<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Travel;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;

class ItineraryController extends Controller
{
    public function index(Request $request)
    {
        $divisions = SYS_Division::with('office')->get();
        $qrs = FTS_Qr::where('status', false)->get();

        if($request->ajax()){

            $documents = FTS_Document::with('itinerary', 'division')
                            ->where('type', config('constants.document.type.travel.itinerary'))
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['status'] = show_status($document->status);


                $records['data'][$i]['name'] = $document->itinerary->name;
                $records['data'][$i]['position'] = $document->itinerary->position;
                $records['data'][$i]['destination'] = $document->itinerary->destination;
                $records['data'][$i]['amount'] = $document->itinerary->amount;
                $records['data'][$i]['purpose'] = $document->itinerary->purpose;



                $action =  fts_action_button($document->series, [
                    'route' => 'fts.travel.itinerary.edit',
                    'id' => $document->id
                ]);


                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);


        }

        return view('filetracking::forms.travel.itinerary.index',[
            'divisions' => $divisions,
            'qrs' => $qrs
        ]);
    }

    public function store(Request $request)
    {
        $series = $request->post('series');

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){
            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = employee_id_helper($request->post('liaison'));

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.travel.itinerary')
        ]);


        $itinerary = FTS_Itinerary::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'destination' => $request->post('destination'),
            'amount' => $request->post('amount'),
            'purpose' => $request->post('purpose'),
        ]);

        // changing QR status
        $qr = FTS_Qr::find($series);
        $qr->status = true;
        $qr->save();


        // INSERTING INTO TRACKING LOGS
        FTS_Tracking::create([
            'document_id' => $document->id,
            'division_id' => Auth::user()->employee->division_id,
            'user_id' => Auth::user()->employee_id,
            'liaison_id' => $liaison,
            'action' => 0,
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(Auth::user()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);


        return response()->json(['message' => 'Itinerary of Travel has been encoded.'], 200);
    }

    public function edit($id)
    {
        $document = FTS_Document::with('itinerary')->findOrFail($id);

        // checking if the document is PR
        dm_abort($document->type, config('constants.document.type.travel.itinerary'));

        $divisions = SYS_Division::with('office')->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        return view('filetracking::forms.travel.itinerary.edit', [
            'divisions' => $divisions,
            'document' => $document
        ]);
    }

    public function update(Request $request, $id)
    {
        // checking the ID if match
        dm_abort(session()->pull('fts.document.edit'), $id);

        $document = FTS_Document::findOrFail($id);

        if($request->post('liaison') != ''){$document->liaison_id = employee_id_helper($request->post('liaison'));}
        $document->division_id = $request->post('division');
        $document->save();

        $itinerary = FTS_Itinerary::where('document_id', $id)->first();
        $itinerary->name = $request->post('name');
        $itinerary->position = $request->post('position');
        $itinerary->destination = $request->post('destination');
        $itinerary->amount = $request->post('amount');
        $itinerary->purpose = $request->post('purpose');
        $itinerary->save();

        return redirect(route('fts.travel.itinerary.index'))->with('alert-success', 'Itinerary of Travel has been updated.');

    }
}
