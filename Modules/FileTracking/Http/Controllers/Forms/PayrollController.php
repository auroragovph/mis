<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;

class PayrollController extends Controller
{
    public function index(Request $request)
    {



        // $rows = DB::table('fts_form_payroll')
        //             ->join('fts_documents', 'fts_form_payroll.document_id', '=', 'fts_documents.id')
        //             ->take(20)
        //             ->get();

        // $rows = FTS_Payroll::with('document')->whereHas('document', function($q){
        //     $q->where('series', 1616);
        // })->take(10)->get();

        //             dd($rows);




        if($request->ajax()){

            $columns = ['encoded', 'series', 'office', 'name', 'amount', 'particulars', 'status'];

            $totalData = FTS_Payroll::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            
            if($request->input('search.value') !== 'MODAL_SEARCH'){
                $documents = FTS_Payroll::with('document.division.office')
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
                $documents = FTS_Payroll::with('document.division.office')
                                            ->whereHas('document', function($q) use($keys){
                                                if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                                                if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                                                if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                                                if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}

                                            })->offset($start)->limit($limit);

                if(array_key_exists('name', $keys)){$documents->where('name', 'like', "%{$keys['name']}%");}
                if(array_key_exists('amount', $keys)){$documents->where('amount', 'like', "%{$keys['amount']}%");}
                if(array_key_exists('particulars', $keys)){$documents->where('particulars', 'like', "%{$keys['particulars']}%");}
                                           
                $documents = $documents->get();


                // TOTAL FILTERS
                $filters = FTS_Payroll::with('document.division.office')
                ->whereHas('document', function($q) use($keys){
                    if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                    if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                    if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                    if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}

                });
                if(array_key_exists('name', $keys)){$filters->where('name', 'like', "%{$keys['name']}%");}
                if(array_key_exists('amount', $keys)){$filters->where('amount', 'like', "%{$keys['amount']}%");}
                if(array_key_exists('particulars', $keys)){$filters->where('particulars', 'like', "%{$keys['particulars']}%");}

                $totalFiltered = $filters->count();

            }

            $records = array();

            foreach($documents as $i => $payroll){

                array_push($records, [
                    
                    'id' => $payroll->document->id,
                    'encoded' => $payroll->document->encoded,
                    'series' => $payroll->document->seriesFull ,
                    'office' => office_helper($payroll->document->division),
                    'status' => show_status($payroll->document->status),

                    'name' => $payroll->name,
                    'amount' => number_format(floatval($payroll->amount), 2),
                    'particulars' => $payroll->particulars,

                    'action' => fts_action_button($payroll->document->series, [
                        'route' => 'fts.payroll.edit',
                        'id' => $payroll->id
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

        return view('filetracking::forms.payroll.index',[
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
            activity('fts')
            ->withProperties([
                'agent' => user_agent()
            ])
            ->log('Tried to store payroll document but failed. Reason: You dont have the permissions to execute this command.');
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
            ->log('Tried to store payroll document but failed. Reason: Series Number already exists!');

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.payroll')
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

        $payroll = FTS_Payroll::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
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
        ->log('Stored payroll document.');
        

        return response()->json([
            'message' => 'Payroll has been encoded.',
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
            ->log('Tried to edit payroll document but failed. Reason: You dont have the permissions to execute this command.');


            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::with('payroll')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.payroll'));

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();
        

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'document_id' => $id,
            'agent' => user_agent()
        ])
        ->log('Tried to edit payroll document.');

        return view('filetracking::forms.payroll.edit', [
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
        if(!auth()->user()->can('fts.document.create')){

            // saving the activity logs
            activity('fts')
            ->withProperties([
                'document_id' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to edit payroll document but failed. Reason: You dont have the permissions to execute this command.');
            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $payroll = FTS_Payroll::where('document_id', $id)->first();
        $payroll->name = $request->post('name');
        $payroll->amount = $request->post('amount');
        $payroll->particulars = $request->post('particulars');
        $payroll->save();

        // saving the activity logs
        activity('fts')
        ->withProperties([
            'document_id' => $id,
            'agent' => user_agent()
        ])
        ->log('Update payroll document.');

        return redirect(route('fts.payroll.index'))->with('alert-success', 'Payroll has been updated.');
    }
}
