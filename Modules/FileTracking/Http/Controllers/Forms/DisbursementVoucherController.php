<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;

class DisbursementVoucherController extends Controller
{
    public function index(Request $request)
    {
        $divisions = SYS_Division::with('office')->get();
        $qrs = FTS_Qr::where('status', false)->get();

        if($request->ajax()){

            $documents = FTS_Document::with('dv', 'division')
                            ->where('type', config('constants.document.type.disbursement'))
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['status'] = show_status($document->status);


                $records['data'][$i]['payee'] = $document->dv->payee;
                $records['data'][$i]['amount'] = $document->dv->amount;
                $records['data'][$i]['particulars'] = $document->dv->particulars;
                $records['data'][$i]['code'] = $document->dv->code;
                $records['data'][$i]['accountable'] = $document->dv->accountable;

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.dv.edit',
                    'id' => $document->id
                ]);


                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);


        }

        return view('filetracking::forms.disbursement.index',[
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
            'type' => config('constants.document.type.disbursement')
        ]);

        $dv = FTS_DisbursementVoucher::create([
            'document_id' => $document->id,
            'payee' => $request->post('payee'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars'),
            'code' => $request->post('code'),
            'accountable' => $request->post('accountable')
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
            'action' => config('constants.document.action.release'),
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(Auth::user()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);

        return response()->json(['message' => 'Disbursement Voucher has been encoded.'], 200);
    }

    public function edit($id)
    {
        $document = FTS_Document::with('dv')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.disbursement'));

        $divisions = SYS_Division::with('office')->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

        return view('filetracking::forms.disbursement.edit', [
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

        $dv = FTS_DisbursementVoucher::where('document_id', $id)->first();
        $dv->payee = $request->post('payee');
        $dv->amount = $request->post('amount');
        $dv->particulars = $request->post('particulars');
        $dv->code = $request->post('code');
        $dv->accountable = $request->post('accountable');
        $dv->save();

        return redirect(route('fts.dv.index'))->with('alert-success', 'Disbursement Voucher has been updated.');
    }
}