<?php

namespace Modules\FileManagement\core\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\core\Models\Procurement\Supplier;
use Modules\FileManagement\core\Http\Requests\Procurement\Supplier\StoreRequest;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::get();
        return view('fms::procurement.supplier.index', compact('suppliers'));
    }

    public function store(StoreRequest $request)
    {
        $supplier = Supplier::create($request->validated());

        return response()->json([
            'data' => $supplier,
            'message' => 'Supplier has been encoded.',
            'title' => 'Success'
        ], 201);
    }
}
