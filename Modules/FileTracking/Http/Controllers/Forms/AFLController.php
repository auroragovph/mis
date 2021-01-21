<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Http\Requests\AFL\StoreRequest;
use Modules\FileTracking\Http\Requests\AFL\UpdateRequest;
use Modules\FileTracking\Transformers\AFLDTResource;

class AFLController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $model = FTS_AFL::with('document')->get();
            $datas = AFLDTResource::collection($model);
            return response()->json($datas);
        }

        return view('filetracking::forms.afl.index');
    }

    public function create()
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.afl.create', [
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function store(StoreRequest $request)
    {
        $document = FTS_Document::create([
            'series' => fts_series($request->post('series')),
            'division_id' => $request->post('division'),
            'liaison_id' => $request->post('liaison'),
            'encoder_id' => authenticated()->employee_id,
            'type' => config('constants.document.type.afl')
        ]);

        $leave = [
            'vacation' => [$request->post('v1'), $request->post('v2')],
            'sick' => [$request->post('s1'), $request->post('s2')]
        ];

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl = FTS_AFL::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'type' => $request->post('type'),
            'credits' => $request->post('credits'),
            'leave' => $leave,
            'inclusives' => [
                'dates' => $inclusives->sort()->values()->all()
            ],
            'particulars' => 'AFL FOR. '.$request->post('name')
        ]);


        // changing QR status
        $qr = FTS_Qr::used($document->series);

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

        return response()->json([
            'message' => 'Application for leave has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $document->series,
                'print' => true
            ])
        ]);

    }

    public function edit($id)
    {
        $afl = FTS_AFL::with('document')->findOrFail($id);

        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.afl.edit', [
            'afl' => $afl,
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $afl = FTS_AFL::with('document')->findOrFail($id);

        $leave = [
            'vacation' => [$request->post('v1'), $request->post('v2')],
            'sick' => [$request->post('s1'), $request->post('s2')]
        ];

        $inclusives = collect([]);

        foreach(explode(',', $request->post('inclusive')) as $date){
            $inclusives->push(Carbon::parse($date)->format('Y-m-d'));
        }

        $afl->update([
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'type' => $request->post('type'),
            'credits' => $request->post('credits'),
            'leave' => $leave,
            'inclusives' => [
                'dates' => $inclusives->sort()->values()->all()
            ],
            'particulars' => 'AFL FOR. '.$request->post('name')
        ]);

        $afl->document()->update([
            'division_id' => $request->post('division'),
            'liaison_id' => $request->post('liaison')
        ]);

        return response()->json([
            'message' => 'Application for leave has been updated.',
            'route' => route('fts.afl.index')
        ], 200);
    }
}
