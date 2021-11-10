<?php

namespace Modules\AwardCommittee\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\AwardCommittee\Entities\Procurement\Supplier;
use Modules\AwardCommittee\Http\Requests\Supplier\StoreRequest;
use Modules\AwardCommittee\Transformers\Supplier\DT;

class SupplierController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return response()->json($this->_dt());
        }

        return view('bac::supplier.index');
    }

    public function create()
    {
        return view('bac::supplier.create');
    }

    public function store(StoreRequest $request)
    {
        $supplier = Supplier::create([
            'name'    => $request->post('name'),
            'owner'   => $request->post('owner'),
            'address' => $request->post('address'),
            'tin'     => $request->post('tin'),
        ]);

        return response()->json([
            'message' => 'Supplier has been created.',
            'intended' => route('bac.supplier.index'),
            'data' => $supplier
        ], 201);
    }

    public function _dt()
    {
        $heading = ['#', 'Name', 'Owner', 'Address', 'TIN', 'Action'];
        $datas   = DT::collection(Supplier::get());
        // $datas = [];
        return [
            'heading' => $heading,
            'data'    => $datas,
        ];
    }
}
