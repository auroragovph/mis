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
    public function create(Request $request)
    {
        $divisions = SYS_Division::with('office')->get();

        return view('humanresource::employee.create', [
            'divisions' => $divisions
        ]);
    } 

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $employee = HR_Employee::create([
            'division_id' => $request->post('division'),
            'position_id' => $request->post('position'),

            'name->fname' => $request->post('fname'),
            'name->lname' => $request->post('lname'),
            'name->mname' => $request->post('mname'),
            'name->sname' => $request->post('sname'),
            'name->title' => $request->post('title'),

            'info->gender' => $request->post('gender'),
            'info->birthday' => $request->post('birthday'),
            'info->address' => $request->post('address'),
            'info->civilStatus' => $request->post('civil'),
            'info->phoneNumber' => $request->post('phone'),

            'employment->phoneNumber' => $request->post('employment-type'),
            'employment->status' => $request->post('employment-status'),
            'employment->leave->vacation' => 0,
            'employment->leave->sick' => 0,

            'card' => $request->post('card'),
            'liaison' => ($request->has('liaison')) ? true : false
        ]);

        return response()->json(['message' => 'Employee has been registered.'], 200);
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

        $employee = HR_Employee::findOrFail($id);

        session(['hrm.employee.edit' => $employee->id]);

        $divisions = SYS_Division::with('office')->get();
        $positions = HR_Plantilla::get();


        return view('humanresource::employee.edit', [
            'employee' => $employee,
            'positions' => $positions,
            'divisions' => $divisions
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $employee = HR_Employee::where('id', $id)->first();

        switch($request->post('_type')){

            case 'profile': 

                $employee->update([
                    'name->fname' => $request->post('fname'),
                    'name->lname' => $request->post('lname'),
                    'name->mname' => $request->post('mname'),
                    'name->fname' => $request->post('fname'),
                    'name->sname' => $request->post('sname'),
                    'name->title' => $request->post('title'),

                    'info->gender' => $request->post('gender'),
                    'info->birthday' => $request->post('birthday'),
                    'info->address' => $request->post('address'),
                    'info->civilStatus' => $request->post('civil'),
                    'info->phoneNumber' => $request->post('phone')
                ]);


                $response['message'] = 'Employee\'s information details has been updated.';

            break;

            case 'employment':

                $employee->update([
                    'employment->type' => $request->post('employment-type'),
                    'employment->status' => $request->post('employment-status'),
                    'division_id' => $request->post('division'),
                    'position_id' => $request->post('position'),
                    'liaison' => ($request->has('liaison')) ? true : false,
                    'card' => employee_id_helper($request->post('card'))
                ]);

                $response['message'] = 'Employee\'s employment details has been updated.';
            break;

            default: 
                $response['message'] = 'Something went wrong.';
            break;

        }

        return response()->json($response, 200);
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
