<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;

class DisbursementVoucherController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $columns = ['encoded', 'series', 'office', 
                            'payee', 'amount', 'particulars', 'code', 'accountable',
                        'status'];

            $totalData = FTS_DisbursementVoucher::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            
            if($request->input('search.value') !== 'MODAL_SEARCH'){
                $documents = FTS_DisbursementVoucher::with('document.division.office')
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
                $documents = FTS_DisbursementVoucher::with('document.division.office')
                                            ->whereHas('document', function($q) use($keys){
                                                if(array_key_exists('encoded', $keys)){$q->where('created_at', $keys['created_at']);}
                                                if(array_key_exists('series', $keys)){$q->where('series', fts_series($keys['series']));}
                                                if(array_key_exists('office', $keys)){$q->where('division_id', $keys['office']);}
                                                if(array_key_exists('status', $keys)){$q->where('status', $keys['status']);}
                                            });

                if(array_key_exists('payee', $keys)){$documents->where('payee', 'like', "%{$keys['payee']}%");}
                if(array_key_exists('amount', $keys)){$documents->where('amount', 'like', "%{$keys['amount']}%");}
                if(array_key_exists('particulars', $keys)){$documents->where('particulars', 'like', "%{$keys['particulars']}%");}
                if(array_key_exists('code', $keys)){$documents->where('code', 'like', "%{$keys['code']}%");}
                if(array_key_exists('accountable', $keys)){$documents->where('accountable', 'like', "%{$keys['accountable']}%");}
                                         
                $filters = $documents;
                $totalFiltered = $filters->count();

                $documents = $documents->offset($start)->limit($limit)->get();

            }

            $records = array();

            foreach($documents as $i => $dv){

                array_push($records, [
                    
                    'id' => $dv->document->id,
                    'encoded' => $dv->document->encoded,
                    'series' => $dv->document->seriesFull ,
                    'office' => office_helper($dv->document->division),
                    'status' => show_status($dv->document->status),

                    'payee' => $dv->payee,
                    'amount' => number_format(floatval($dv->amount), 2),
                    'particulars' => $dv->particulars,
                    'code' => $dv->code,
                    'accountable' => $dv->accountable,


                    'action' => fts_action_button($dv->document->series, [
                        'route' => 'fts.dv.edit',
                        'id' => $dv->id
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

        return view('filetracking::forms.disbursement.index',[
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
            ->log('Tried to store disbursement voucher document but failed. Reason: You dont have the permissions to execute this command.');

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
            ->log('Tried to store disbursement voucher document but failed. Reason: Series Number already exists.');

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        // $liaison = employee_id_helper($request->post('liaison'));
        $liaison = $request->post('liaison');

        

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.disbursement')
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

        $dv = FTS_DisbursementVoucher::create([
            'document_id' => $document->id,
            'payee' => $request->post('payee'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars'),
            'code' => $request->post('code'),
            'accountable' => $request->post('accountable')
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
        ->log('Store disbursement voucher document.');

        return response()->json([
            'message' => 'Disbursement Voucher has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ], 200);
    }

    public function edit($id)
    {
        $document = FTS_Document::with('dv')->findOrFail($id);

        // checking permissions
        if(!auth()->user()->can('fts.document.edit')){
           
            // saving the activity logs
            activity('fts')
            ->withProperties([
                'document_id' => $id,
                'agent' => user_agent()
            ])
            ->log('Tried to edit disbursement voucher document but failed. Reason: You dont have the permissions to execute this command.');

            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        // checking type
        dm_abort($document->type, config('constants.document.type.disbursement'));

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
         ->log('Tried to edit disbursement voucher document.');


        return view('filetracking::forms.disbursement.edit', [
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
                 'document_id' => $id,
                 'agent' => user_agent()
             ])
             ->log('Tried to update disbursement voucher document but failed. Reason: You dont have the permissions to execute this command.');
 
            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 403);
        }

        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $dv = FTS_DisbursementVoucher::where('document_id', $id)->first();
        $dv->payee = $request->post('payee');
        $dv->amount = $request->post('amount');
        $dv->particulars = $request->post('particulars');
        $dv->code = $request->post('code');
        $dv->accountable = $request->post('accountable');
        $dv->save();

         // saving the activity logs
         activity('fts')
         ->withProperties([
             'document_id' => $id,
             'agent' => user_agent()
         ])
         ->log('Update disbursement voucher document.');


        return redirect(route('fts.dv.index'))->with('alert-success', 'Disbursement Voucher has been updated.');
    }
}
