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
        if($request->ajax()){

            $datas = array();


            if($request->has('term') OR $request->post('term') != ''){
                $rows = HR_Plantilla::where('position', 'like', '%'.$request->post('term').'%')->get();
                foreach($rows as $row){
                    array_push($datas, [
                        'id' => $row->id,
                        'text' => $row->position
                    ]);
                }
            }

            return response()->json($datas, 200);


            
        }

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
        $name = [
            'fname' => $request->post('fname'),
            'lname' => $request->post('lname'),
            'mname' => $request->post('mname'),
            'sname' => $request->post('sname'),
            'title' => $request->post('title')
        ];

        $info = [
            'gender' => $request->post('gender'),
            'birthday' => $request->post('birthday'),
            'address' => $request->post('address'),
            'civil' => $request->post('civil'),
            'phone' => $request->post('phone')
        ];

        $employment = [
            'type' => $request->post('employment-type'),
            'status' => $request->post('employment-status'),
            'leave' => [
                'vacation' => 0,
                'sick' => 0
            ]
        ];

        $employee = HR_Employee::create([
            'division_id' => $request->post('division'),
            'position_id' => $request->post('position'),
            'name' => $name,
            'info' => $info,
            'employement' => $employment,
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
