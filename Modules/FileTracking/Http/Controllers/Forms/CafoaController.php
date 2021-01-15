<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Http\Requests\Cafoa\CafoaStoreRequest;

class CafoaController extends Controller
{
    public function index()
    {
        return view('filetracking::forms.cafoa.index');
    }

    public function create()
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.cafoa.create', [
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function store(CafoaStoreRequest $request)
    {
        // checking permissions
        if(!authenticated()->can('fts.document.edit')){

            // saving the activity logs
            activitylog([
                'name' => 'fts',
                'log' => 'Tried to store CAFOA document but failed. Reason: You dont have the permissions to execute this command.'
            ]);
            return response()->json(['message' => 'You dont have the permissions to execute this command.'], 406);
        }

        $series = fts_series($request->post('series'));

        // checking if the series already exists
        $check = FTS_Document::where('series', $series)->count();
        if($check != 0){

            // saving the activity logs
            activitylog([
                'name' => 'fts',
                'log' => 'Tried to store CAFOA document but failed. Reason: Series Number already exists.'
            ]);

            return response()->json(['message' => 'Series Number already exists!'], 406);
        }

        $liaison = $request->post('liaison');

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => authenticated()->employee_id,
            'type' => config('constants.document.type.cafoa')
        ]);

      
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
            'division_id' => authenticated()->employee->division_id,
            'user_id' => authenticated()->employee_id,
            'liaison_id' => $liaison,
            'action' => config('constants.document.action.release'),
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(authenticated()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);

        // saving the activity logs
        activitylog([
            'name' => 'fts',
            'log' => 'Tried to store CAFOA.'
        ]);

        return response()->json([
            'message' => 'CAFOA has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ], 200);
    }
}
