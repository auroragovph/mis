<?php

namespace Modules\HumanResource\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\HumanResource\Http\Requests\Employee\EmployeeStoreRequest;
use Modules\HumanResource\Transformers\Employee\EmployeeDTResource;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return EmployeeDTResource::collection(HR_Employee::with('division.office', 'position')->get());
        }

        return view('humanresource::employee.index');
    }

    public function create()
    {
        $divisions = SYS_Division::with('office')->get();
        return view('humanresource::employee.create', [
            'divisions' => $divisions
        ]);
    }

    public function store(EmployeeStoreRequest $request)
    {

        // checking if request has file
        if($request->hasFile('profile_avatar')){

            $file = $request->file('profile_avatar');
            $path = $file->store('public/employees/profile');
            $image_name = str_replace('public/employees/profile/', '', $path);

        }else{
            $image_name = null;
        }

        $employee = HR_Employee::create([
            'division_id' => $request->post('division'),
            'position_id' => $request->post('position'),

            'name->fname' => $request->post('firstname'),
            'name->lname' => $request->post('lastname'),
            'name->mname' => $request->post('middlename'),
            'name->sname' => $request->post('sname'),
            'name->title' => $request->post('title'),

            'info->gender' => $request->post('sex'),
            'info->birthday' => $request->post('birthday'),
            'info->address' => $request->post('address'),
            'info->civilStatus' => $request->post('civil'),
            'info->phoneNumber' => $request->post('phone'),
            'info->image' => $image_name,

            'employment->type' => $request->post('appointment'),
            'employment->status' => 'active',
            'employment->leave->vacation' => 0,
            'employment->leave->sick' => 0,

            'card' => $request->post('card'),
            'liaison' => ($request->has('liaison')) ? true : false
        ]);


        // creating an account

        return response()->json(['message' => 'Employee has been registered.']);
    }
}
