<?php

namespace Modules\FileTracking\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class PurchaseRequestController extends Controller
{
    
    public function index(Request $request)
    {


        if($request->ajax()){

            $columns = ['encoded', 'series', 'office', 
                            'number', 'date', 'particular', 'purpose', 'charging', 'accountable', 'amount',
                        'status'];

            $totalData = FTS_PurchaseRequest::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')]; 
            $dir = $request->input('order.0.dir');

            
            if($request->input('search.value') !== 'MODAL_SEARCH'){
                $documents = FTS_PurchaseRequest::with('document.division.office')
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
                $documents = FTS_PurchaseRequest::with('document.division.office')
                                            ->whereHas('document', function($q) use($keys){
                                                if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                                                if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                                                if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                                                if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}

                                            });

                if(array_key_exists('number', $keys)){$documents->where('number', 'like', "%{$keys['number']}%");}
                if(array_key_exists('date', $keys)){$documents->where('date', 'like', "%{$keys['date']}%");}
                if(array_key_exists('particular', $keys)){$documents->where('particular', 'like', "%{$keys['particular']}%");}
                if(array_key_exists('purpose', $keys)){$documents->where('purpose', 'like', "%{$keys['purpose']}%");}
                if(array_key_exists('charging', $keys)){$documents->where('charging', 'like', "%{$keys['charging']}%");}
                if(array_key_exists('accountable', $keys)){$documents->where('accountable', 'like', "%{$keys['accountable']}%");}
                if(array_key_exists('amount', $keys)){$documents->where('amount', 'like', "%{$keys['amount']}%");}
                                           
                $filters = $documents;
                $totalFiltered = $filters->count();

                $documents = $documents->offset($start)->limit($limit)->get();
                

            }

            $records = array();

            foreach($documents as $i => $pr){

                array_push($records, [
                    
                    'id' => $pr->document->id,

                    'encoded' => $pr->document->encoded,
                    'series' => $pr->document->seriesFull ,
                    'office' => office_helper($pr->document->division),
                    'status' => show_status($pr->document->status),

                    'number' => $pr->number,
                    'date' => $pr->date,
                    'particular' => $pr->particular,
                    'purpose' => $pr->purpose,
                    'charging' => $pr->charging,
                    'accountable' => $pr->accountable,
                    'amount' => number_format(floatval($pr->amount), 2),

                    'action' => fts_action_button($pr->document->series, [
                        'route' => 'fts.payroll.edit',
                        'id' => $pr->id
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

        return view('filetracking::forms.procurement.request.index',[
            'divisions' => $divisions ?? null,
            'qrs' => $qrs ?? null,
            'liaisons' => $liaisons ?? null,
            'attachments' => $attachments ?? null,

        ]);
    }

    public function store(Request $request)
    {
        // checking permissions
        if(!auth()->user()->can('fts.document.create')){
            // saving the activity logs
            actlog('fts', "Tried to store purchase request document but failed. Reason: You dont have the permissions to execute this command.");
            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }


        $series = $request->post('series');

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store purchase request document but failed. Reason: Series Number already exists.');

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        // $liaison = employee_id_helper($request->post('liaison'));
        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.procurement.request')
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

       

        $pr = FTS_PurchaseRequest::create([
            'document_id' => $document->id, 
            'number' => $request->post('number'), 
            'date' => $request->post('date'), 
            'particular' => $request->post('particulars'), 
            'purpose' => $request->post('purpose'), 
            'charging' => $request->post('charging'), 
            'accountable' => $request->post('accountable'), 
            'amount' => $request->post('amount')
        ]);


        // changing QR status
        $qr = FTS_Qr::used($series);

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

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'agent' => user_agent()
        ])
        ->log('Encode purchase request document');

        return response()->json([
            'message' => 'Purchase Request has been encoded.',
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
            ->log('Tried to edit purchase request document but failed. Reason: Not enough permission to edit the document.');

            return abort(403);
        }

        $document = FTS_Document::with('purchase_request')->findOrFail($id);

        // checking if the document is PR
        dm_abort($document->type, config('constants.document.type.procurement.request'));

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
        ->log('Tried to edit purchase request document.');


        return view('filetracking::forms.procurement.request.edit', [
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
            ->log('Tried to edit purchase request document but failed. Reason: Not enough permission to edit the document.');
            return abort(403);
        }

        $document = FTS_Document::findOrFail($id);

        if($request->post('liaison') != ''){$document->liaison_id = employee_id_helper($request->post('liaison'));}
        $document->division_id = $request->post('division');
        $document->save();

        $pr = FTS_PurchaseRequest::where('document_id', $id)->first();
        $pr->number = $request->post('number');
        $pr->date = $request->post('date');
        $pr->particular = $request->post('particulars');
        $pr->purpose = $request->post('purpose');
        $pr->charging = $request->post('charging');
        $pr->accountable = $request->post('accountable');
        $pr->amount = $request->post('amount');
        $pr->save();


        // saving the activity logs
        activity('fts')
        ->withProperties([
            'series' => $document->series,
            'agent' => user_agent()
        ])
        ->log('Update the purchase request document');



        return redirect(route('fts.procurement.request.index'))->with('alert-success', 'Purchase Request has been updated');

    }
}
