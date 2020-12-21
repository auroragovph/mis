<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Travel;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\FileTracking\Entities\FTS_AFL;
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

            $columns = ['encoded', 'series', 'office', 
                            'number', 'employees', 'destination', 'departure', 'arrival', 'purpose',
                        'status'];

            $totalData = FTS_TravelOrder::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if($request->input('search.value') !== 'MODAL_SEARCH'){
                $documents = FTS_TravelOrder::with('document.division.office')
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
                $documents = FTS_TravelOrder::with('document.division.office')
                                            ->whereHas('document', function($q) use($keys){
                                                if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                                                if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                                                if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                                                if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}

                                            });

                if(array_key_exists('number', $keys)){$documents->where('number', 'like', "%{$keys['number']}%");}
                if(array_key_exists('employees', $keys)){$documents->where('employees', 'like', "%{$keys['employees']}%");}
                if(array_key_exists('destination', $keys)){$documents->where('destination', 'like', "%{$keys['destination']}%");}
                if(array_key_exists('departure', $keys)){$documents->where('departure', 'like', "%{$keys['departure']}%");}
                if(array_key_exists('arrival', $keys)){$documents->where('arrival', 'like', "%{$keys['arrival']}%");}
                if(array_key_exists('purpose', $keys)){$documents->where('purpose', 'like', "%{$keys['purpose']}%");}
                                           
                $filters = $documents;
                $totalFiltered = $filters->count();

                $documents = $documents->offset($start)->limit($limit)->get();
            }

            $records = array();

            foreach($documents as $i => $to){

                array_push($records, [
                    
                    'id' => $to->document->id,
                    'encoded' => $to->document->encoded,
                    'series' => $to->document->seriesFull ,
                    'office' => office_helper($to->document->division),
                    'status' => show_status($to->document->status),

                    'name' => $to->name,
                    'number' => $to->number,
                    'employees' => implode(', ', $to->employees),
                    'destination' => $to->destination,
                    'departure' => $to->departure,
                    'arrival' => $to->arrival,
                    'purpose' => $to->purpose,

                    'action' => fts_action_button($to->document->series, [
                        'route' => 'fts.travel.order.edit',
                        'id' => $to->document->id
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

        if($request->has('attachments')){
            $attachments = array();
        
            foreach($request->post('attachments') as $i => $attachment){
                $attachments[$i]['document_id'] = $document->id;
                $attachments[$i]['employee_id'] = auth()->user()->employee_id;
                $attachments[$i]['description'] = $attachment;
                $i++;
            }

            FTS_DA::insert($attachments);
        }


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
