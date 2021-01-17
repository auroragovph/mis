<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Http\Requests\Payroll\PayrollStoreRequest;
use Modules\FileTracking\Http\Requests\Payroll\UpdateRequest;
use Modules\FileTracking\Transformers\PayrollDTResource;

class PayrollController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $model = FTS_Payroll::with('document')->get();
            $datas = PayrollDTResource::collection($model);
            return response()->json($datas);
        }
        return view('filetracking::forms.payroll.index');
    }

    public function create()
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.payroll.create', [
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function store(PayrollStoreRequest $request)
    {

        $series = fts_series($request->post('series'));

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){

            // saving the activity logs
            activitylog([
                'name' => 'fts',
                'log' => 'Tried to store Payroll document but failed. Reason: Series Number already exists.'
            ]);

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' =>  $request->post('liaison'),
            'encoder_id' => authenticated()->employee_id,
            'type' => config('constants.document.type.payroll')
        ]);

        
        // changing QR status
        $qr = FTS_Qr::used($series);

        $payroll = FTS_Payroll::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'amount' => $request->post('amount'),
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
            'message' => 'Payroll has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ]);
    }

    public function edit($id)
    {
        $payroll = FTS_Payroll::with('document')->findOrFail($id);

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.payroll.edit', [
            'payroll' => $payroll,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $payroll = FTS_Payroll::with('document')->findOrFail($id);

        $payroll->update([
            'name' => $request->post('name'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars')
        ]);

        $payroll->document()->update([
            'division_id' => $request->post('division'),
            'liaison_id' => $request->post('liaison')
        ]);

        return response()->json([
            'message' => 'Payroll has been updated.',
            'route' => route('fts.payroll.index')
        ]);
    }
}
