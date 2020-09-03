<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Document\FMS_DocumentLog;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseOrder;
use Modules\FileManagement\Entities\Procurement\FMS_PurchaseOrderData;

class PurchaseOrderController extends Controller
{
    public function index()
    {

    }

    public function create($id)
    {

        $document = FMS_Document::with('purchase_request')->findOrFail($id);

        $employees = HR_Employee::where('division_id', Auth::user()->employee->division_id)->get();
        $divisions = SYS_Division::with('office')->get();


        // SETTING SESSION ID FOR EDITING DOCUMENT
        session(['fms.documents.edit' => $document->id]);

        return view('filemanagement::form-procurement.order.create', [
            'document' => $document,
            'employees' => $employees,
            'divisions' => $divisions
        ]);
        
    }

    public function store(Request $request, $id)
    {
        $id = session()->pull('fms.document.edit');

        $document = FMS_Document::with('purchase_request')->find($id);
        $document->liaison_id = $request->liaison;
        $document->type = 302;
        $document->save();


        $po = FMS_PurchaseOrder::create([
            "document_id" => $id,
            "number" => $request->number,
            "supplier" => $request->supplier,
            "address" => $request->address,
            "telephone" => $request->telephone,
            "date" => $request->date,
            "mop" => $request->mop,
            "delivery_place" => $request->delivery_place,
            "delivery_date" => $request->delivery_date,
            "delivery_term" => $request->delivery_term,
            "delivery_payment_term" => $request->delivery_payment_term,
            "requesitioning_id" => $request->requesitioning_id,
            "accounting_id" => $request->accounting_id
        ]);

        foreach($request->cost as $key => $item){
            if($item == null || $item == ''){continue;}
            $lists[$key]['po_id'] = $po->id;
            $lists[$key]['stock'] = $request['stock'][$key];
            $lists[$key]['unit'] = $request['unit'][$key];
            $lists[$key]['description'] = $request['desc'][$key];
            $lists[$key]['qty'] = $request['qty'][$key];
            $lists[$key]['cost'] = $request['cost'][$key];
        }

        FMS_PurchaseOrderData::insert($lists);


         // logging
          // logging
        FMS_DocumentLog::log($document->id, 'Create the document.');

        // notifying liaison

        // redirect with message
        return redirect(route('fms.procurement.order.show', $id))->with('alert-success', 'Purchase order has been created.');



    }
}
