<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Procurement\FMS_PO;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Order\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Order\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Procurement\Order\OrderDTResource;

class POController extends FormController
{
    public function __construct()
    {
        $this->model = PurchaseOrder::class;
        $this->doctype = config('constants.document.type.procurement.order');
        $this->alias = 'purchase_order';
        $this->routes = [
            'show' => 'fms.procurement.order.show'
        ];
    }

    public function index()
    {
        if(request()->ajax()){

            $model = PurchaseOrder::with('document.division.office')->whereHas('document', function($q){
                $q->where('division_id', auth_division());
            })->get();

            $datas = OrderDTResource::collection($model);
            return response()->json(["data" => $datas]);
        }

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request purchase request list.']);

        return view('filemanagement::forms.procurement.order.index');
    }

    public function create(Request $request)
    {
        $id = (int)$request->get('document');

        $document = Document::with('purchase_request')
            ->where('id', $id)
            ->where('type', config('constants.document.type.procurement.request'))
            ->firstOrFail();

        $employees = HR_Employee::get();


        // setting sessions
        session(['fms.document.create.po' => $document->id]);


        return view('filemanagement::forms.procurement.order.create', [
            'document' => $document,
            'employees' => $employees
        ]);
    }

    public function store(StoreRequest $request)
    {

        $id = session()->get('fms.document.create.po');

        $document = Document::with('purchase_request')
            ->where('id', $id)
            ->where('type', config('constants.document.type.procurement.request'))
            ->firstOrFail();



        $forms = [
            'document_id'           => $id,
            'approving_id'          => $request->post('approving'),
            'number'                => $request->post('number'),
            'mode_of_procurement'   => $request->post('mode_of_procurement'),
            'particulars'           => $request->post('particulars'),
            'pr_number'             => $request->post('pr_number'),
            'lists'                 => $request->post('lists'),
            'supplier'              => array(
                                        'firm'      => $request->post('supplier_firm'),
                                        'name'      => $request->post('supplier_name'),
                                        'address'   => $request->post('supplier_address'),
                                        'tin'       => $request->post('supplier_tin'),
                                        ),
            'delivery'              => array(
                                        'place'    => $request->post('delivery_place'),
                                        'date'     => $request->post('delivery_date'),
                                        'term'     => $request->post('delivery_term'),
                                        'payment'  => $request->post('delivery_payment'),
                                        )
            ];

        $po = $this->save($forms, true);


        // changing status of the document
        $document->update([
            'type' => config('constants.document.type.procurement.order')
        ]);

        if(request()->ajax()){
            return response()->json([
                'message' => "Purchase order has been encoded.",
                'route' => route('fms.procurement.order.show', $po->id)
            ], 201);
        }

        return redirect(route('fms.procurement.order.show', $po->id))
                ->with('alert-success', "Purchase order has been encoded.");
    }

    public function show($id)
    {
        $po = $this->details($id);

        if(request()->has('print') && request()->get('print') == true){
            
            return view('filemanagement::forms.procurement.order.print', [
                'po' => $po
            ]);
        }

        return view('filemanagement::forms.procurement.order.show', [
            'po' => $po
        ]);

    }

    public function edit($id)
    {
        $po = PurchaseOrder::with('document')->findOrFail($id);
        $employees = HR_Employee::get();
        // setting sessions
        session(['fms.document.edit.po' => $po->id]);

        return view('filemanagement::forms.procurement.order.edit', [
            'po' => $po,
            'employees' => $employees
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $forms = [
            'approving_id'          => $request->post('approving'),
            'number'                => $request->post('number'),
            'mode_of_procurement'   => $request->post('mode_of_procurement'),
            'particulars'           => $request->post('particulars'),
            'pr_number'             => $request->post('pr_number'),
            'lists'                 => $request->post('lists'),
            'supplier'              => array(
                                        'firm'      => $request->post('supplier_firm'),
                                        'name'      => $request->post('supplier_name'),
                                        'address'   => $request->post('supplier_address'),
                                        'tin'       => $request->post('supplier_tin'),
                                        ),
            'delivery'              => array(
                                        'place'    => $request->post('delivery_place'),
                                        'date'     => $request->post('delivery_date'),
                                        'term'     => $request->post('delivery_term'),
                                        'payment'  => $request->post('delivery_payment'),
                                        )
        ];

        $po = $this->patch($id, $forms);

        if(request()->ajax()){
            return response()->json([
                    'message' => "Purchase order has been updated.",
                    'route' => route('fms.procurement.order.show', $po->id)
                ]);
        }

        return redirect(route('fms.procurement.order.show', $po->id))->with('alert-success', "Purchase order has been updated.");

    }

    public function print($id)
    {
        $po = PurchaseOrder::with(
            'document.attachments',
            'document.liaison',
            'document.encoder',
            'document.division.office',

            'approving.position'


            )->findOrFail($id);


        return view('filemanagement::forms.procurement.order.print', [
            'po' => $po
        ]);
    }
}
