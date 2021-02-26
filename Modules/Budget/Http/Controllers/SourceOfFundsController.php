<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Budget\Entities\Budget_SOF;
use Modules\Budget\Http\Requests\SOF\StoreRequest;

class SourceOfFundsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $sofs = Budget_SOF::get();
        return view('budget::source_of_funds.index', [
            'sofs' => $sofs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return void
     */
    public function store(StoreRequest $request)
    {
        Budget_SOF::create($request->validated());
        return redirect()->back()->with('alert-success', 'Source of funds has been created.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
