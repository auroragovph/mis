<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\System\Entities\Office\Division;
use Modules\System\Transformers\Employee\DT;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\HumanResource\Entities\Employee\Position;
use Modules\System\Http\Requests\Employee\StoreRequest;
use Modules\System\Http\Requests\Employee\UpdateRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            return $this->_dt();
        }
        return view('system::employees.index');
    }

    public function create()
    {
        $divisions = Division::with('office')->get();
        $positions = Position::get();

        return view('system::employees.credit', [
            'positions' => $positions,
            'divisions' => $divisions,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $employee = Employee::create([
            'position_id' => $request->post('position'),
            'division_id' => $request->post('division'),
            'name'        => [
                'first'  => $request->post('fname'),
                'last'   => $request->post('lname'),
                'middle' => $request->post('mname'),
                'title'  => '',
                'suffix' => '',
            ],

            'info'        => [
                'address'     => $request->post('address'),
                'sex'         => $request->post('sex'),
                'birthday'    => $request->post('bday'),
                'civilStatus' => $request->post('civil'),
            ],

            'employment'  => [
                'type'   => $request->post('appointment'),
                'leave'  => [
                    'sick'     => 0,
                    'vacation' => 0,
                ],
                'status' => true,
                'image'  => null,
            ],

            'card'        => $request->post('card'),
            'liaison'     => $request->has('liaison') ? true : false,
        ]);

        session()->flash('alert-success', 'Employee has been registered.');

        return response()->json([
            'message'  => 'Employee has been created.',
            'intended' => route('sys.admin.employee.index'),
        ], 201);
    }

    public function edit($id)
    {
        $divisions = Division::with('office')->get();
        $positions = Position::get();
        $employee  = Employee::findOrFail($id);

        return view('system::employees.credit', [
            'employee'  => $employee,
            'positions' => $positions,
            'divisions' => $divisions,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update([
            'position_id' => $request->post('position'),
            'division_id' => $request->post('division'),
            'name'        => [
                'first'  => $request->post('fname'),
                'last'   => $request->post('lname'),
                'middle' => $request->post('mname'),
                'title'  => '',
                'suffix' => '',
            ],

            'info'        => [
                'address'     => $request->post('address'),
                'sex'         => $request->post('sex'),
                'birthday'    => $request->post('bday'),
                'civilStatus' => $request->post('civil'),
            ],

            'employment'  => [
                'type'   => $request->post('appointment'),
                'leave'  => [
                    'sick'     => 0,
                    'vacation' => 0,
                ],
                'status' => true,
                'image'  => null,
            ],

            'card'        => $request->post('card'),
            'liaison'     => $request->has('liaison') ? true : false,
        ]);

        return response()->json([
            'message'  => 'Employee has been updated.',
            'intended' => route('sys.admin.employee.index'),
        ], 200);


    }

    public function _dt()
    {
        $heading = ['#', 'Name', 'Office', 'Position', 'Appoint', 'Action'];
        $datas   = DT::collection(Employee::with('division.office', 'position')->get());
        return [
            'heading' => $heading,
            'data'    => $datas ?? [],
        ];
    }

}
