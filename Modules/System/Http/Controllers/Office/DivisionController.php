<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\Office;
use Illuminate\Contracts\Support\Renderable;
use Modules\System\Entities\Office\Division;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\System\Http\Requests\Division\StoreRequest;
use Modules\System\Http\Requests\Division\UpdateRequest;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $divisions = Division::with('office', 'head')->where('name', '!=', 'MAIN')->get();
        $offices = Office::get();
        $employees = Employee::get();

        return view('system::office.division.index', [
            'offices' => $offices,
            'divisions' => $divisions,
            'employees' => $employees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreRequest $request)
    {
        $division = Division::create([
            'name' => $request->post('name'),
            'alias' => $request->post('alias'),
            'office_id' => $request->post('office'),
            'head_id' => $request->post('division_head')
        ]);

        // activity logs
        actlog('sys', 'Division created', ['id' => $division->id]);

        return redirect(route('sys.admin.division.index'))
                ->with('alert-success', 'Office has been created.');

                
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Division $division)
    {
        $employees = Employee::get();
        $offices = Office::get();

        return view('system::office.division.edit', [
            'division' => $division,
            'offices' => $offices,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRequest $request, Division $division)
    {
        $division->update([
            'name' => $request->post('name'),
            'alias' => $request->post('alias'),
            'office_id' => $request->post('office'),
            'head_id' => $request->post('division_head')
        ]);

        // flashing session
        session()->flash('alert-success', 'Division has been updated.');

        return redirect(route('sys.admin.division.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort(403);
    }
}
