<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Travel;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

class ItineraryController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $columns = ['encoded', 'series', 'office', 
                            'name', 'position', 'destination', 'amount', 'purpose',
                        'status'];

            $totalData = FTS_Itinerary::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if($request->input('search.value') !== 'MODAL_SEARCH'){
                $documents = FTS_Itinerary::with('document.division.office')
                                        ->whereHas('document')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->get();
            }else{

                $columns = $request->input('columns');
                $keys = [];
                foreach($columns as $column){
                    if($column['search']['value'] !== null){
                        $keys[$column['data']] = $column['search']['value'];
                        
                    }
                }

                // SEARCHING
                $documents = FTS_Itinerary::with('document.division.office')
                                            ->whereHas('document', function($q) use($keys){
                                                if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                                                if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                                                if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                                                if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}
                                            });

                if(array_key_exists('name', $keys)){$documents->where('name', 'like', "%{$keys['name']}%");}
                if(array_key_exists('position', $keys)){$documents->where('position', 'like', "%{$keys['position']}%");}
                if(array_key_exists('destination', $keys)){$documents->where('destination', 'like', "%{$keys['destination']}%");}
                if(array_key_exists('amount', $keys)){$documents->where('amount', 'like', "%{$keys['amount']}%");}
                if(array_key_exists('purpose', $keys)){$documents->where('purpose', 'like', "%{$keys['purpose']}%");}

                $filters = $documents;
                $totalFiltered = $filters->count();

                $documents = $documents->offset($start)->limit($limit)->get();

            }

            $records = array();

            foreach($documents as $i => $iot){

                array_push($records, [
                    
                    'id' => $iot->document->id,
                    'encoded' => $iot->document->encoded,
                    'series' => $iot->document->seriesFull ,
                    'office' => office_helper($iot->document->division),
                    'status' => show_status($iot->document->status),

                    'name' => $iot->name,
                    'position' => $iot->position,
                    'destination' => $iot->destination,
                    'amount' => $iot->amount,
                    'purpose' => $iot->purpose,

                    'action' => fts_action_button($iot->document->series, [
                        'route' => 'fts.travel.itinerary.edit',
                        'id' => $iot->document->id
                    ])
                ]);
            }

            $records = collect($records);

            // sorting
            $records = ($dir == 'asc') ? $records->sortBy($order) : $records->sortByDesc($order);

            // $totalFiltered= $records->count();

            return response()->json([
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $records->values()->toArray() ?? [] 
            ]);


        }
        
        if(auth()->user()->can('fts.document.create')){
            $divisions = SYS_Division::lists();
            $qrs = FTS_Qr::available();
            $liaisons = HR_Employee::liaison()->get();
            $attachments = FTS_DA::lists();

        }

        $attachment = 'ABCD';

        return view('filetracking::forms.travel.itinerary.index',[
            'divisions' => $divisions ?? null,
            'qrs' => $qrs ?? null,
            'liaisons' => $liaisons ?? null,
            'attachment' => $attachment,
            'attachments' => $attachments ?? null,
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
            ->log('Tried to store itinerary of travel document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to access this function.'], 403);
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
            ->log('Tried to store itinerary of travel document but failed. Reason: Series Number already exists.');

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.travel.itinerary')
        ]);

        $attachments = array();
        foreach($request->post('attachments') as $i => $attachment){
            $attachments[$i]['document_id'] = $document->id;
            $attachments[$i]['employee_id'] = auth()->user()->employee_id;
            $attachments[$i]['description'] = $attachment;
            $i++;
        }
        FTS_DA::insert($attachments);
        
        $itinerary = FTS_Itinerary::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'destination' => $request->post('destination'),
            'amount' => $request->post('amount'),
            'purpose' => $request->post('purpose'),
        ]);

        // changing QR status
        $qr = FTS_Qr::used($series);


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'agent' => user_agent()
        ])
        ->log('Encode itinerary of travel document');


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


        return response()->json([
            'message' => 'Itinerary of Travel has been encoded.',
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
            ->log('Tried to edit itinerary but failed. Reason: Not enough permission to edit the document.');

            return abort(403);
        }


        $document = FTS_Document::with('itinerary')->findOrFail($id);

        // checking if the document is PR
        dm_abort($document->type, config('constants.document.type.travel.itinerary'));

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();


        // setting up the sessions
        session(['fts.document.edit' => $document->id]);


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Tried to edit itinerary document.');


        return view('filetracking::forms.travel.itinerary.edit', [
            'divisions' => $divisions,
            'document' => $document,
            'liaisons' => $liaisons
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
            ->log('Tried to edit itinerary of travel document but failed. Reason: Not enough permission to edit the document.');

            return abort(403);
        }

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


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Update the itinerary of travel document');

        return redirect(route('fts.travel.itinerary.index'))->with('alert-success', 'Itinerary of Travel has been updated.');

    }
}
