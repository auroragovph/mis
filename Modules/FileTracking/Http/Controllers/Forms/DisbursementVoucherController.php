<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Http\Requests\DV\StoreRequest;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;
use Modules\FileTracking\Http\Requests\DV\UpdateRequest;
use Modules\FileTracking\Transformers\DVDTResource;

class DisbursementVoucherController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $model = FTS_DisbursementVoucher::with('document')->get();
            $datas = DVDTResource::collection($model);
            return response()->json($datas);
        }

        return view('filetracking::forms.dv.index');
    }

    public function create()
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.dv.create', [
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function store(StoreRequest $request)
    {
        $series = fts_series($request->post('series'));

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){

            // saving the activity logs
            activitylog([
                'name' => 'fts',
                'log' => 'Tried to store DV document but failed. Reason: Series Number already exists.'
            ]);

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' =>  $request->post('liaison'),
            'encoder_id' => authenticated()->employee_id,
            'type' => config('constants.document.type.disbursement')
        ]);

        
        // changing QR status
        $qr = FTS_Qr::used($series);

        $payroll = FTS_DisbursementVoucher::create([
            'document_id' => $document->id,
            'payee' => $request->post('payee'),
            'amount' => $request->post('amount'),
            'accountable' => $request->post('accountable'),
            'code' => $request->post('code'),
            'particulars' => $request->post('particulars')
        ]);

        // INSERTING INTO TRACKING LOGS
        FTS_Tracking::create([
            'document_id' => $document->id,
            'division_id' => authenticated()->employee->division_id,
            'user_id' => authenticated()->employee_id,
            'liaison_id' => $request->post('liaison'),
            'action' => config('constants.document.action.release'),
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(authenticated()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);

        // saving the activity logs
        activitylog([
            'name' => 'fts',
            'log' => 'Tried to store Payroll.'
        ]);

        return response()->json([
            'message' => 'DV has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ]);
    }

    public function edit($id)
    {
        $dv = FTS_DisbursementVoucher::with('document')->findOrFail($id);

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.dv.edit', [
            'dv' => $dv,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $dv = FTS_DisbursementVoucher::with('document')->findOrFail($id);

        $dv->update([
            'payee' => $request->post('payee'),
            'amount' => $request->post('amount'),
            'code' => $request->post('code'),
            'accountable' => $request->post('accountable'),
            'particulars' => $request->post('particulars')
        ]);

        $dv->document()->update([
            'division_id' => $request->post('division'),
            'liaison_id' => $request->post('liaison')
        ]);

        return response()->json([
            'message' => 'Disbursement Voucher has been updated.',
            'route' => route('fts.dv.index')
        ]);
    }
}
