<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

class CafoaController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $columns = ['encoded', 'series', 'office', 'number', 'payee', 'amount', 'particulars', 'status'];

            $totalData = FTS_Cafoa::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if($request->input('search.value') !== 'MODAL_SEARCH'){
                $documents = FTS_Cafoa::with('document.division.office')
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
                $documents = FTS_Cafoa::with('document.division.office')
                                            ->whereHas('document', function($q) use($keys){
                                                if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                                                if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                                                if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                                                if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}
                                            })->offset($start)->limit($limit);

                if(array_key_exists('number', $keys)){$documents->where('number', 'like', "%{$keys['number']}%");}
                if(array_key_exists('payee', $keys)){$documents->where('number', 'like', "%{$keys['payee']}%");}
                if(array_key_exists('amount', $keys)){$documents->where('number', 'like', "%{$keys['amount']}%");}
                if(array_key_exists('particulars', $keys)){$documents->where('number', 'like', "%{$keys['particulars']}%");}
                                           
                $documents = $documents->get();


                // TOTAL FILTERS
                $filters = FTS_Cafoa::with('document.division.office')
                ->whereHas('document', function($q) use($keys){
                    if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                    if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                    if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                    if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}
                });

                if(array_key_exists('number', $keys)){$documents->where('number', 'like', "%{$keys['number']}%");}
                if(array_key_exists('payee', $keys)){$documents->where('number', 'like', "%{$keys['payee']}%");}
                if(array_key_exists('amount', $keys)){$documents->where('number', 'like', "%{$keys['amount']}%");}
                if(array_key_exists('particulars', $keys)){$documents->where('number', 'like', "%{$keys['particulars']}%");}

                $totalFiltered = $filters->count();
            }

            $records = array();

            foreach($documents as $i => $cafoa){
                array_push($records, [
                    'id' => $cafoa->document->id,
                    'encoded' => $cafoa->document->encoded,
                    'series' => $cafoa->document->seriesFull ,
                    'office' => office_helper($cafoa->document->division),
                    'status' => show_status($cafoa->document->status),

                    'number' => $cafoa->number,
                    'payee' => $cafoa->payee,
                    'amount' => number_format(floatval($cafoa->amount), 2),
                    'particulars' => $cafoa->particulars,

                    'action' => fts_action_button($cafoa->document->series, [
                        'route' => 'fts.cafoa.edit',
                        'id' => $cafoa->document->id
                    ])
                ]);
            }


            $records = collect($records);

            // sorting
            $records = ($dir == 'asc') ? $records->sortBy($order) : $records->sortByDesc($order);


            return response()->json([
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $records->values()->toArray() ?? [] 
            ], 200);

        }


        if(auth()->user()->can('fts.document.create')){
            $divisions = SYS_Division::lists();
            $qrs = FTS_Qr::available();
            $liaisons = HR_Employee::liaison()->get();
            $attachments = FTS_DA::lists();

        }

        return view('filetracking::forms.cafoa.index',[
            'divisions' => $divisions ?? null,
            'qrs' => $qrs ?? null,
            'liaisons' => $liaisons ?? null,
            'attachments' => $attachments ?? null,
            
        ]);
    }

    public function store(Request $request)
    {
        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store CAFOA document but failed. Reason: You dont have the permissions to execute this command.');

            return abort(403);
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
            ->log('Tried to store CAFOA document but failed. Reason: Series Number already exists');


            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.cafoa')
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

        $cafoa = FTS_Cafoa::create([
            'document_id' => $document->id,
            'number' => $request->post('number'),
            'payee' => $request->post('payee'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars')
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
            'document_id' => $document->id,
            'agent' => user_agent()
        ])
        ->log('Tried to store CAFOA document.');

        return response()->json([
            'message' => 'CAFOA has been encoded.',
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
                'document_id' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to edit CAFOA document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::with('cafoa')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.cafoa'));

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'agent' => user_agent()
        ])
        ->log('Edit CAFOA document.');


        return view('filetracking::forms.cafoa.edit', [
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
                'document_id' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to update CAFOA document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $cafoa = FTS_Cafoa::where('document_id', $document->id)->first();
        $cafoa->number = $request->post('number');
        $cafoa->payee = $request->post('payee');
        $cafoa->amount = $request->post('amount');
        $cafoa->particulars = $request->post('particulars');
        $cafoa->save();


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'document_id' => $id,
            'agent' => user_agent()
        ])
        ->log('Update CAFOA document.');

        return redirect(route('fts.cafoa.index'))->with('alert-success', 'CAFOA has been updated.');
    }
}
