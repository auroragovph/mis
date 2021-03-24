<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Procurement\FMS_PO;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentAttach;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Order\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Order\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Procurement\Order\OrderDTResource;

class POController extends Controller
{
    public function index()
    {
        if(request()->ajax()){

            $model = FMS_PO::with('document.division.office')->whereHas('document', function($q){
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
        

        $document = FMS_Document::with('purchase_request')
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

        $document = FMS_Document::with('purchase_request')
            ->where('id', $id)
            ->where('type', config('constants.document.type.procurement.request'))
            ->firstOrFail();



        $po = FMS_PO::create([
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
        ]);


        // changing status of the document
        $document->update([
            'type' => config('constants.document.type.procurement.order')
        ]);

        // setting session
        // session()->flash('alert-success', 'Purchase order has been encoded.');

        // adding attachmeent
        // FMS_DocumentAttach::create([
        //     'document_id' => $id,
        //     'description' => 'Purchase Order',
        //     'mime'  => 'url/sys',
        //     'url'   => json_encode(array('fms.procurement.order.show', $po->id))
        // ]);

        return redirect(route('fms.procurement.order.show', $po->id))->with('alert-success', "Purchase order has been encoded.");

        // return response()->json([
        //     'message' => "Purchase order has been encoded.",
        //     'route' => route('fms.procurement.order.show', $po->id)
        // ]);


    }

    public function show($id)
    {
        $po = FMS_PO::with(
            'document.attachments',
            'document.liaison',
            'document.encoder',
            'document.division.office',
            )->findOrFail($id);


        return view('filemanagement::forms.procurement.order.show', [
            'po' => $po
        ]);
    }

    public function edit($id)
    {

        $po = FMS_PO::with('document')->findOrFail($id);

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
        $po = FMS_PO::findOrFail($id);

        $po->update([
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
        ]);

        return redirect(route('fms.procurement.order.show', $po->id))->with('alert-success', "Purchase order has been updated.");


        // return response()->json([
        //     'message' => "Purchase order has been updated.",
        //     'route' => route('fms.procurement.order.show', $po->id)
        // ]);

    }

    public function print($id)
    {
        $po = FMS_PO::with(
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
