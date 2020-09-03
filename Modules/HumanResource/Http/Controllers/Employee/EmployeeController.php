<?php

namespace Modules\HumanResource\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\HumanResource\Entities\HR_Plantilla;
use Modules\System\Entities\Office\SYS_Division;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $employees = HR_Employee::with('position', 'division.office')->get();
        // echo json_encode($employees);
        // return die;
        return view('humanresource::employee.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $divisions = SYS_Division::with('office')->get();
        $positions = HR_Plantilla::get();
        return view('humanresource::employee.create', [
            'divisions' => $divisions,
            'positions' => $positions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('humanresource::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('humanresource::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
