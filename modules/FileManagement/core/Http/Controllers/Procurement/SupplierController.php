<?php

namespace Modules\FileManagement\core\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\core\Models\Procurement\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::get();
        return view('fms::procurement.supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $supplier = Supplier::create([
            'name'    => $request->post('name'),
            'owner'   => $request->post('owner'),
            'address' => $request->post('address'),
            'tin'     => $request->post('tin'),
        ]);

        return response()->json([
            'message' => 'Supplier has been encoded.',
            'title' => 'Success',
            'intended' => route('fms.procurement.supplier.index')
        ], 201);
    }
}
