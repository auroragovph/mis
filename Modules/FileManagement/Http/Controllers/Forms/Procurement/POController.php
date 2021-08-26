<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Modules\AwardCommittee\Entities\Procurement\Supplier;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;
use Modules\FileManagement\Http\Controllers\Forms\FormController;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Order\StoreRequest;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Order\UpdateRequest;
use Modules\FileManagement\Transformers\Forms\Procurement\Order\OrderDTResource;
use Modules\HumanResource\Entities\Employee\Employee;

class POController extends FormController
{
    public function __construct()
    {
        $this->model    = PurchaseOrder::class;
        $this->doctype  = config('constants.document.type.procurement.order');
        $this->alias    = 'purchase_order';
        $this->circular = 2020;
        $this->routes   = [
            'show' => 'fms.procurement.order.show',
        ];
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $model = PurchaseOrder::with('document.division.office')->whereHas('document', function ($q) {
                $q->where('division_id', auth_division());
            })->get();

            $datas = OrderDTResource::collection($model);
            return response()->json($datas);
        }


        $orders = PurchaseOrder::with('document.division.office')->whereHas('document', function ($q) {
            $q->where('division_id', auth_division());
        })->get();  

        return view('filemanagement::forms.procurement.order.index', [
            'orders' => $orders
        ]);
    }

    public function create(Request $request)
    {
        $attached = session_attached_form();
        (!$attached) ? abort(404) : '';

        // finding PR in the formable lists
        $document = Document::with('forms.formable')->find($request->get('document_id'));
        $prs      = $document->forms->where('formable_type', 'Purchase Request');

        if ($prs->isEmpty()) {
            session()->flash('alert-warning', 'System cannot find any attached Purchase Request form. Please check the form.');
        }

        return view('filemanagement::forms.procurement.order.' . $this->circular . '.create', [
            'document'  => $document,
            'employees' => Employee::get(),
            'suppliers' => Supplier::get(),
            'prs'       => $prs,
        ]);
    }

    public function store(StoreRequest $request)
    {

        $id       = session()->pull('fms.document.attach');
        $document = Document::find($id);

        $forms = [
            'document_id'         => $id,
            'supplier_id'         => $request->post('supplier'),
            'circular'            => $this->circular,
            'number'              => $request->post('number'),
            'mode_of_procurement' => $request->post('mode_of_procurement'),
            'particulars'         => $request->post('particulars'),
            'pr_number'           => explode(',', $request->post('pr_number')),
            'lists'               => $request->post('lists'),
            'signatories'         => $this->signatories($request),
            'delivery'            => array(
                'place'   => $request->post('delivery_place'),
                'date'    => $request->post('delivery_date'),
                'term'    => $request->post('delivery_term'),
                'payment' => $request->post('delivery_payment'),
            ),
        ];

        $po = $this->save($forms, true);

        // changing status of the document if the main document is purchase request
        if ($document->type == config('constants.document.type.procurement.request')) {
            $document->update([
                'type' => config('constants.document.type.procurement.order'),
            ]);
        }

        $route   = route('fms.procurement.order.show', $po->id);
        $message = "Purchase order has been encoded.";

        if (request()->ajax()) {

            return response()->json([
                'message'  => $message,
                'intended' => $route,
            ], 201);
        }

        return redirect($route)->with('alert-success', $message);
    }

    public function show($id)
    {
        $rels = ['supplier_rel'];

        $po = $this->details($id, $rels);

        if (request()->has('print') && request()->get('print') == true) {

            return view('filemanagement::forms.procurement.order.print', [
                'po' => $po,
            ]);
        }

        return view('filemanagement::forms.procurement.order.' . $po->circular . '.show', [
            'po' => $po,
        ]);

    }

    public function edit($id)
    {
        $po        = PurchaseOrder::with('document')->findOrFail($id);
        $employees = Employee::get();
        $suppliers = Supplier::get();

        // setting sessions
        session(['fms.document.edit.po' => $po->id]);

        return view('filemanagement::forms.procurement.order.' . $po->circular . '.edit', [
            'po'        => $po,
            'employees' => $employees,
            'suppliers' => $suppliers,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $signatories = $this->signatories($request);

        $forms = [
            'supplier_id'         => $request->post('supplier'),
            'number'              => $request->post('number'),
            'mode_of_procurement' => $request->post('mode_of_procurement'),
            'particulars'         => $request->post('particulars'),
            'pr_number'           => explode(',', $request->post('pr_number')),
            'lists'               => $request->post('lists'),
            'signatories'         => $signatories,

            'delivery'            => array(
                'place'   => $request->post('delivery_place'),
                'date'    => $request->post('delivery_date'),
                'term'    => $request->post('delivery_term'),
                'payment' => $request->post('delivery_payment'),
            ),
        ];

        $po = $this->patch($id, $forms);

        $route   = route('fms.procurement.order.show', $po->id);
        $message = "Purchase order has been updated.";

        if (request()->ajax()) {
            return response()->json([
                'message'  => $message,
                'intended' => $route,
            ]);
        }

        return redirect($route)->with('alert-success', $message);

    }

    function print($id) {
        $po = PurchaseOrder::with(
            'document.attachments',
            'document.liaison',
            'document.encoder',
            'document.division.office',

            'approving.position'

        )->findOrFail($id);

        return view('filemanagement::forms.procurement.order.print', [
            'po' => $po,
        ]);
    }

    public function signatories($request)
    {
        $employees = Employee::with('position')->whereIn('id', [
            $request->post('approver'),
        ])->get();

        $approver = $employees->where('id', $request->post('approver'))->first();

        $signatories = [
            'approver' => [
                'id'       => $approver->id ?? null,
                'name'     => name_helper($approver->name ?? null),
                'position' => $approver->position->name ?? null,
            ],

        ];

        return $signatories;
    }
}
