<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\FTS_Payroll;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $documents = FTS_Document::with('payroll', 'division.office')
                            ->where('type', config('constants.document.type.payroll'))
                            ->get();

            $records['data'] = array();

            foreach($documents as $i => $document){

                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['encoded'] = $document->encoded;
                $records['data'][$i]['series'] = $document->seriesFull;
                $records['data'][$i]['office'] = office_helper($document->division);
                $records['data'][$i]['status'] = show_status($document->status);


                $records['data'][$i]['name'] = $document->payroll->name;
                $records['data'][$i]['amount'] = $document->payroll->amount;
                $records['data'][$i]['particulars'] = $document->payroll->particulars;

                $action =  fts_action_button($document->series, [
                    'route' => 'fts.payroll.edit',
                    'id' => $document->id
                ]);


                $records['data'][$i]['action'] = $action;
            }

            return response()->json($records, 200);


        }


        $divisions = SYS_Division::with('office')->get();
        $qrs = FTS_Qr::where('status', false)->get();
        $liaisons = HR_Employee::liaison()->get();


        return view('filetracking::forms.payroll.index',[
            'liaisons' => $liaisons,
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

        $liaison = $request->post('liaison');


        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' => $liaison,
            'encoder_id' => Auth::user()->id,
            'type' => config('constants.document.type.payroll')
        ]);

        $payroll = FTS_Payroll::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars')
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

        return response()->json(['message' => 'Payroll has been encoded.'], 200);
    }

    public function edit($id)
    {
        $document = FTS_Document::with('payroll')->findOrFail($id);

        // checking type
        dm_abort($document->type, config('constants.document.type.payroll'));

        $divisions = SYS_Division::with('office')->get();
        $liaisons = HR_Employee::liaison()->get();

        // setting up the sessions
        session(['fts.document.edit' => $document->id]);

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

        $document = FTS_Document::findOrFail($id);

        $document->liaison_id = $request->post('liaison');
        $document->division_id = $request->post('division');
        $document->save();

        $payroll = FTS_Payroll::where('document_id', $id)->first();
        $payroll->name = $request->post('name');
        $payroll->amount = $request->post('amount');
        $payroll->particulars = $request->post('particulars');
        $payroll->save();

        return redirect(route('fts.payroll.index'))->with('alert-success', 'Payroll has been updated.');
    }
}
