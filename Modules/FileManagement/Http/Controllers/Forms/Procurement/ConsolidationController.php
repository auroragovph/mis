<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Procurement\FMS_PR;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\Tracking;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Request\PRStoreRequest;

class ConsolidationController extends Controller
{
    public function index()
    {
        return view('filemanagement::forms.procurement.consolidation.index');
    }

    public function check(Request $request)
    {
        $qrs = array();

        foreach ($request->documents as $document) {
            $qrs[series($document)] = $document;
        }


        $valid_qrs = collect();
        $invalid_qrs = collect();

        $doc_ids = array();

        $documents = FMS_Document::whereIn('id', array_keys($qrs))->get();

        foreach ($documents as $document) {

            $doc = $qrs[$document->id];

            if ($doc !== $document->qr) {

                $invalid_qrs->push([
                    'document' => $doc ?? null,
                    'message'   => 'QR Code Not Found'
                ]);

                continue;
            }

            if ($document->status == 1) {
                $invalid_qrs->push([
                    'document' => $doc,
                    'message'   => 'Document is not activate.'
                ]);
                continue;
            }

            if ($document->type !== config('constants.document.type.procurement.request')) {
                $invalid_qrs->push([
                    'document' => $doc,
                    'message'   => 'Document is not a purchase request.'
                ]);
                continue;
            }

            $valid_qrs->push([
                'id'        => $document->id,
                'document'  => $doc,
                'message'   => null
            ]);

            array_push($doc_ids, $document->id);
        }

        if ($valid_qrs->count() == 0) {
            return redirect()->back()->with('alert-error', 'All input QR Code is invalid. Please try again.');
        }

        session(['fms.procurement.consolidate' => $doc_ids]);

        return view('filemanagement::forms.procurement.consolidation.check', [
            'qrcodes'   => $valid_qrs->merge($invalid_qrs)
        ]);
    }
    public function form()
    {
        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        $divisions = SYS_Division::lists();

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request new purchase request form.']);

        return view('filemanagement::forms.procurement.consolidation.form', [
            'employees' => $employees,
            'divisions' => $divisions
        ]);
    }

    public function store(PRStoreRequest $request)
    {
        // storing document
        $document = FMS_Document::create([
            'division_id'   => $request->post('division'),
            'liaison_id'    => $request->post('liaison'),
            'encoder_id'    => authenticated()->employee_id,
            'status'        => 2,
            'type'          => config('constants.document.type.procurement.request'),
            'properties'    => ['consolidated' => true]
        ]);

        $pr = FMS_PR::create([
            'document_id'       => $document->id,
            'requesting_id'     => $request->post('requesting'),
            'treasury_id'       => $request->post('treasury'),
            'approving_id'      => $request->post('approving'),
            'number'            => $request->post('number'),
            'fund'              => $request->post('fund'),
            'fpp'               => $request->post('fpp'),
            'purpose'           => $request->post('purpose'),
            'lists'             => $request->post('lists'),
            'properties'        => [
                                        'consolidated' => true,
                                    ]
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Encode purchase request consolidated',
            'props' => [
                'model' => [
                    'id' => $pr->id,
                    'class' => FMS_PR::class
                ]
            ]
        ]);

        $inserts = array();
        $now = now();
        // inserting to tracks
        foreach(session('fms.procurement.consolidate') as $ids){
            array_push($inserts, [
                'document_id'   => $ids,
                'user_id'       => authenticated()->employee_id,
                'liaison_id'    => null,
                'division_id'   => authenticated()->employee->division_id,
                'action'        => config('constants.document.action.receive'),
                'purpose'       => 'Purchase request has been consolidated with new QR Code: '.$document->qr,
                'status'        => config('constants.document.status.process.id'),
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
        Tracking::insert($inserts);


        // setting session
        session()->flash('alert-success', 'Purchase request has been encoded.');

        return response()->json([
            'message' => "Purchase request has been encoded.",
            'route' => route('fms.procurement.request.show', $pr->id)
        ]);
    }
}
