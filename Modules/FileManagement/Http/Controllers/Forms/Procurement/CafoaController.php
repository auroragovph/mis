<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Http\Requests\Forms\Cafoa\CafoaStoreRequest;

class CafoaController extends Controller
{
    public function create($id)
    {
        $document = FMS_Document::with('purchase_order')
            ->where('type', config('constants.document.type.procurement.order'))
            ->findOrFail($id);

        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        activitylog(['name' => 'fms', 'log' => 'Request cafoa form']);


        return view('filemanagement::forms.procurement.cafoa.create', [
            'employees' => $employees,
            'document'  => $document,
            'amount' => collect($document->purchase_order->lists)->sum(function ($row) {
                return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
            })
        ]);
    }

    public function store(CafoaStoreRequest $request, $id)
    {
        // storing document
        $document = FMS_Document::find($id);
        $document->type = config('constants.document.type.procurement.cafoa');
        $document->save();

        $cafoa = FMS_Cafoa::create([
            'payee' => $request->post('payee'),
            'document_id' => $document->id,
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'budget_id' => $request->post('budget'),
            'accountant_id' => $request->post('accountant'),
            'requesting_id' => $request->post('requesting'),
            'lists' => $request->post('lists')
        ]);

        // setting session
        session()->flash('alert-success', 'Cafoa has been encoded.');

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Encode cafoa',
            'props' => [
                'model' => [
                    'id' => $cafoa->id,
                    'class' => FMS_Cafoa::class
                ]
            ]
        ]);

        return response()->json([
            'message' => "CAFOA has been encoded.",
            'route' => route('fms.procurement.cafoa.show', $cafoa->id)
        ]);
    }

    public function show($id)
    {
        $cafoa = FMS_Cafoa::with(
            'document.attachments',
            'document.liaison',
            'document.encoder',
            'document.division.office',
            'requesting',
            'budget',
            'accounting',
            'treasury'
        )->findOrFail($id);

        if($cafoa->document->type !== config('constants.document.type.procurement.cafoa')){
            return abort(404);
        }

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request information of CAFOA',
            'props' => [
                'model' => [
                    'id' => $cafoa->id,
                    'class' => FMS_Cafoa::class
                ]
            ]
        ]);

        return view('filemanagement::forms.procurement.cafoa.show', compact('cafoa'));
    }
}
