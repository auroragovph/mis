<?php

namespace Modules\System\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\Office;
use Illuminate\Contracts\Support\Renderable;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\System\Http\Requests\Office\StoreRequest;
use Modules\System\Http\Requests\Office\UpdateRequest;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $offices = Office::with('divisions', 'head')->get();
        $employees = Employee::get();

        return view('system::office.index', [
            'offices' => $offices,
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
        $office = Office::create([
            'name' => $request->post('name'),
            'alias' => $request->post('alias'),
            'head_id' => $request->post('department_head')
        ]);

        // activity logs
        actlog('sys', 'Office created', ['id' => $office->id]);

        return redirect(route('sys.admin.office.index'))
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
    public function edit(Office $office)
    {
        $employees = Employee::get();
        return view('system::office.edit', [
            'office' => $office,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRequest $request, Office $office)
    {
        $office->update([
            'name'                  => $request->post('name'),
            'alias'                 => $request->post('alias'),
            'head_id'    => $request->post('department_head'),
        ]);

        // flashing session
        session()->flash('alert-success', 'Office has been updated.');

        return redirect(route('sys.admin.office.index'));
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
