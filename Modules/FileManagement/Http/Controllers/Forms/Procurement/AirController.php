<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Procurement\Air;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Air\StoreRequest;

class AirController extends FormController
{

    public function index()
    {
        return view('filemanagement::forms.procurement.air.index');
    }

    public function create(Request $request)
    {
        // check if the qr code exists
        $qr_id = series($request->get('number'));

        $document = Document::where('type', config('constants.document.type.procurement.order'))
            ->where('id', $qr_id)
            ->first();


        // checking document if exists
        if (!$document or $document->qr !== $request->get('number')) {

            $document = PurchaseOrder::where('number', $request->get('number'))->first();

            if (!$document) {
                return redirect(route('fms.procurement.air.index'))->with('alert-error', 'QR Code / PO Number not found');
            }
        }


        if (get_class($document) !== PurchaseOrder::class) {
            $document = $document->purchase_order;
        }


        return view('filemanagement::forms.procurement.air.create', [
            'po' => $document
        ]);


    }

    public function store(StoreRequest $request)
    {
        $air = Air::create([
            'document_id' => $request->post('document_id'),
            'po_id' => $request->post('po_id'),
            'number' => $request->post('number'),
            'invoice' => array(
                'number' => $request->post('invoice_number'),
                'date' => $request->post('invoice_date'),
            ),

            'lists' => $request->post('lists')
        ]);

        $air->formable()->create([
            'document_id' => $request->post('document_id'),
        ]);

        return redirect(route('fms.procurement.air.show', $air->id))->with('alert-success', 'Form has been encoded');
    }

    public function show($id)
    {
        $air = Air::with('document.attachments')->findOrFail($id);

        return view('filemanagement::forms.procurement.air.show', [
            'air' => $air,
            'po' => $air->document->purchase_order
        ]);
    }
}
