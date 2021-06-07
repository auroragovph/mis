<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Procurement\Air;
use Modules\FileManagement\Entities\Procurement\FMS_PO;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Procurement\IAR\StoreRequest;

class IARController extends FormController
{

    public function index()
    {
        return view('filemanagement::forms.procurement.inspection.iar.index');
    }

    public function create(Request $request)
    {
        // check if the qr code exists
        $qr_id = series($request->get('number'));

        $proctypes = array_values(config('constants.document.type.procurement'));

        $document = FMS_Document::whereIn('type', $proctypes)
            ->where('id', $qr_id)
            ->first();

        // checking document if exists
        if (!$document or $document->qr !== $request->get('number')) {

            $document = FMS_PO::where('number', $request->get('number'))->first();
            if (!$document) {
                return redirect(route('fms.procurement.iar.index'))->with('alert-error', 'QR Code / PO Number not found');
            }
        }


        if (get_class($document) !== FMS_PO::class) {
            $document = $document->purchase_order();
        }

        return view('filemanagement::forms.procurement.inspection.iar.create', [
            'po' => $document
        ]);
    }

    public function store(StoreRequest $request)
    {
        $air = Air::create([
            'document_id' => $request->post('document_id'),
            'po_id' => $request->post('po_id'),
            'number' => $request->post('number'),
            'invoice' => $request->post('invoice'),
            'invoice_date' => $request->post('invoice_date'),
            'lists' => $request->post('lists')
        ]);

        $air->formable()->create([
            'document_id' => $request->post('document_id'),
        ]);

        return redirect(route('fms.procurement.iar.show', $air->id))->with('alert-success', 'Form has been encoded');
    }

    public function show($id)
    {
        $air = Air::with('document')->findOrFail($id);


        return view('filemanagement::forms.procurement.inspection.iar.show', [
            'air' => $air,
            'po' => $air->document->purchase_order
        ]);
    }
}
