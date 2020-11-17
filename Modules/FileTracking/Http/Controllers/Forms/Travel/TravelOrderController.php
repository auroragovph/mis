<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Travel;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;

class TravelOrderController extends Controller
{
   
    public function index(Request $request)
    {

        if($request->ajax()){

            $documents = FTS_Document::with('travel_order', 'division.office')
                            ->whereHas('travel_order')
                            ->where('type', config('constants.document.type.travel.order'))
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                if($document->travel_order == null){continue;}

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['status'] = show_status($document->status);


                $records['data'][$i]['number'] = $document->travel_order->number;
                $records['data'][$i]['employees'] = implode(', ', $document->travel_order->employees);
                $records['data'][$i]['destination'] = $document->travel_order->destination;
                $records['data'][$i]['departure'] = $document->travel_order->departure;
                $records['data'][$i]['arrival'] = $document->travel_order->arrival;
                $records['data'][$i]['purpose'] = $document->travel_order->purpose;

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.travel.order.edit',
                    'id' => $document->id
                ]);


                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);


        }


        if(auth()->user()->can('fts.document.create')){


            $divisions = SYS_Division::lists();
            $qrs = FTS_Qr::available();
            $liaisons = HR_Employee::liaison()->get();
            $attachments = FTS_DA::lists();
            $employees = FTS_TravelOrder::lists();

        }

        return view('filetracking::forms.travel.order.index',[
            'liaisons' => $liaisons ?? null,
            'divisions' => $divisions ?? null,
            'qrs' => $qrs ?? null,
            'attachments' => $attachments ?? null,
            'employees' => $employees ?? null,
        ]);
    }

    public function store(Request $request)
    {
        
        // checking permissions
        if(!auth()->user()->can('fts.document.create')){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store travel order document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }


        $series = fts_series($request->post('series'));

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store travel order document but failed. Reason: Series Number already exists.');

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.travel.order')
        ]);

        $attachments = array();
        foreach($request->post('attachments') as $i => $attachment){
            $attachments[$i]['document_id'] = $document->id;
            $attachments[$i]['employee_id'] = auth()->user()->employee_id;
            $attachments[$i]['description'] = $attachment;
            $i++;
        }
        FTS_DA::insert($attachments);


        $to = FTS_TravelOrder::create([
            'document_id' => $document->id,
            'number' => $request->post('number'),
            'date' => $request->post('date'),
            'destination' => $request->post('destination'),
            'employees' => $request->post('employees'),
            'departure' => $request->post('departure'),
            'arrival' => $request->post('arrival'),
            'purpose' => $request->post('purpose'),
        ]);

        // changing QR status
        $qr = FTS_Qr::used($series);

        // INSERTING INTO TRACKING LOGS
        FTS_Tracking::create([
            'document_id' => $document->id,
            'division_id' => Auth::user()->employee->division_id,
            'user_id' => Auth::user()->employee_id,
            'liaison_id' => $liaison,
            'action' => config('constants.document.action.release'),
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(Auth::user()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $series,
            'agent' => user_agent()
        ])
        ->log('Encode travel order document');

        return response()->json([
            'message' => 'Travel Order has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ], 200);
    }

    public function edit($id)
    {
        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){
            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to edit travel order but failed. Reason: Not enough permission to edit the document.');
            return abort(403);
        }

        $document = FTS_Document::with('travel_order')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.travel.order'));

        $divisions = SYS_Division::with('office')->get();
        $liaisons = HR_Employee::liaison()->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Tried to edit travel order document.');

        return view('filetracking::forms.travel.order.edit', [
            'divisions' => $divisions,
            'liaisons' => $liaisons,
            'document' => $document
        ]);
    }

    public function update(Request $request, $id)
    {
        // checking the ID if match
        dm_abort(session()->pull('fts.document.edit'), $id);

        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to edit travel order document but failed. Reason: Not enough permission to edit the document.');

            return abort(403);
        }

        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $to = FTS_TravelOrder::where('document_id', $id)->first();
        $to->number = $request->post('number');
        $to->date = $request->post('date');
        $to->employees = $request->post('employees');
        $to->destination = $request->post('destination');
        $to->departure = $request->post('departure');
        $to->arrival = $request->post('arrival');
        $to->purpose = $request->post('purpose');
        $to->save();

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Update the travel order document');


        return redirect(route('fts.travel.order.index'))->with('alert-success', 'Travel Order has been updated.');
    }
}
