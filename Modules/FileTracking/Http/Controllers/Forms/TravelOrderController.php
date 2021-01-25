<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Http\Requests\TO\StoreRequest;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;
use Modules\FileTracking\Http\Requests\TO\UpdateRequest;
use Modules\FileTracking\Transformers\TODTResource;

class TravelOrderController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $model = FTS_TravelOrder::with('document')->get();
            $datas = TODTResource::collection($model);
            return response()->json($datas);
        }

        return view('filetracking::forms.to.index');
    }

    public function create()
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.to.create', [
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function store(StoreRequest $request)
    {
        $series = fts_series($request->post('series'));

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' =>  $request->post('liaison'),
            'encoder_id' => authenticated()->employee_id,
            'type' => config('constants.document.type.travel.order')
        ]);

        
        // changing QR status
        $qr = FTS_Qr::used($series);

        $to = FTS_TravelOrder::create([
            'document_id' => $document->id,

            'number'        => $request->post('number'),
            'date'          => $request->post('date'),
            'employees'     => $request->post('employees'),
            'destination'   => $request->post('destination'),
            'departure'     => $request->post('departure'),
            'arrival'       => $request->post('arrival'),
            'particulars'   => $request->post('particulars')
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
            'log' => 'Tried to store travel order.'
        ]);

        return response()->json([
            'message' => 'Travel Order has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ]);
    }

    public function edit($id)
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();
        $to = FTS_TravelOrder::with('document')->findOrFail($id);

        return view('filetracking::forms.to.edit', [
            'to' => $to,
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $to = FTS_TravelOrder::with('document')->findOrFail($id);

        $to->update([
            'number'        => $request->post('number'),
            'date'          => $request->post('date'),
            'employees'     => $request->post('employees'),
            'destination'   => $request->post('destination'),
            'departure'     => $request->post('departure'),
            'arrival'       => $request->post('arrival'),
            'particulars'   => $request->post('particulars')
        ]);

        $to->document()->update([
            'division_id' => $request->post('division'),
            'liaison_id' => $request->post('liaison')
        ]);

        return response()->json([
            'message' => 'Travel Order has been updated.',
            'route' => route('fts.travel.order.index')
        ], 200);


    }
}
