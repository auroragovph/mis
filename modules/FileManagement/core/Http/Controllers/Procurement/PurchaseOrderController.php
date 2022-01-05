<?php

namespace Modules\FileManagement\core\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use Modules\FileManagement\core\Enums\Document\Type;
use Modules\FileManagement\core\Enums\Document\Type as DocumentType;
use Modules\FileManagement\core\Http\Controllers\FormController;
use Modules\FileManagement\core\Http\Requests\Procurement\PurchaseOrder\StoreRequest;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\FileManagement\core\Models\Procurement\PurchaseOrder;
use Modules\FileManagement\core\Models\Procurement\Supplier;
use Modules\HumanResource\core\Models\Employee\Employee;

class PurchaseOrderController extends FormController
{
    public function __construct()
    {
        $this->model    = PurchaseOrder::class;
        $this->doctype  = Type::PROCUREMENT_PURCHASE_ORDER->value;
        $this->alias    = 'purchase_order';
        $this->circular = 2022;
        $this->routes   = [
            'show' => 'fms.procurement.order.show',
        ];
    }

    public function index()
    {
        if (request()->ajax()) {

            // $model = PurchaseRequest::with('series')->whereHas('series', function ($q) {
            //     $q->where('office_id', authenticated('office_id'));
            // })->get();

            $model = PurchaseOrder::with('series.office')->get();

            $datas = \Modules\FileManagement\core\Http\Resources\Procurement\PurchaseOrder\DT::collection($model);

            return response()->json($datas);
        }

        return view('fms::procurement.order.index');
    }

    public function create(Request $request)
    {
        if (!$this->is_attachment()) {
            return abort(404);
        }

        // finding PR in the formable lists
        $document = Series::with('forms.formable')->findOrFail($request->get('series_id'));

        $prs = $document->forms->where('formable_type', 'Purchase Request');

        if ($prs->isEmpty()) {
            session()->flash('alert-warning', 'System cannot find any attached Purchase Request form. Please check the form.');
        }

        $pr_numbers = collect();

        foreach ($prs as $pr) {
            $pr_numbers->push($pr->formable->number);
        }

        return view('fms::procurement.order.' . $this->circular . '.create', [
            'document'   => $document,
            'employees'  => Employee::get(),
            'suppliers'  => Supplier::get(),
            'prs'        => $prs,
            'pr_numbers' => $pr_numbers,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $id       = session()->get('fms.document.attach');
        $document = Series::find($id);

        $forms = $this->form_data($request, $id);
        $forms['series_id'] = $id;

        $po = $this->save($forms, true);

        // changing status of the document if the main document is purchase request
        if ($document->type == DocumentType::PROCUREMENT_PURCHASE_REQUEST->value ) {

            $document->update([
                'type' => DocumentType::PROCUREMENT_PURCHASE_ORDER->value,
            ]);
        }

        $route   = route('fms.procurement.order.show', $po->id);
        $message = "Purchase order has been encoded.";

        return response()->json([
            'message'  => $message,
            'intended' => $route,
        ], 201);
    }

    public function show($id)
    {
        $po = $this->details($id);

        if (request()->has('print') && request()->get('print') == true) {

            return view('filemanagement::forms.procurement.order.print', [
                'po' => $po,
            ]);
        }

        return view('fms::procurement.order.' . $po->circular . '.show', [
            'po' => $po,
        ]);

    }

    public function edit($id)
    {
        $po = $this->details($id);

        return view('fms::procurement.order.' . $po->circular . '.edit', [
            'po' => $po,
            'employees'  => Employee::get(),
            'suppliers'  => Supplier::get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $po = $this->patch($id, $this->form_data($request));

        return response()->json([
            'message'  => "Purchase Order has been updated.",
            'intended' => route('fms.procurement.order.show', $id),
        ]);
    }

    protected function form_data($request)
    {
        return [
            'circular'            => $this->circular,
            'number'              => $request->post('number'),
            'mode_of_procurement' => $request->post('mode_of_procurement'),
            'particulars'         => $request->post('particulars'),
            'pr_number'           => explode(',', $request->post('pr_number')),
            'lists'               => $request->post('lists'),
            'signatories'         => $this->signatories($request),
            'supplier'            => $this->supplier($request->post('supplier')),
            'delivery'            => array(
                'place'   => $request->post('delivery_place'),
                'date'    => $request->post('delivery_date'),
                'term'    => $request->post('delivery_term'),
                'payment' => $request->post('delivery_payment'),
            ),
        ];
    }

    protected function signatories($request)
    {
        $employees = Employee::with('position')->whereIn('id', [
            $request->post('approver'),
        ])->get();

        $approver = $employees->where('id', $request->post('approver'))->first();

        $signatories = [
            'approver' => [
                'id'       => $approver->id ?? null,
                'name'     => name($approver->name ?? null),
                'position' => $approver->position->name ?? null,
            ],

        ];

        return $signatories;
    }

    protected function supplier($id)
    {
        $supplier = Supplier::find($id);
        $supplier = collect($supplier->toArray());
        return $supplier->except('created_at', 'updated_at')->toArray();
    }
}
