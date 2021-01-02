<?php

namespace Modules\HumanResource\Http\Controllers\Employee;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\HumanResource\Http\Requests\Employee\EmployeeStoreRequest;
use Modules\HumanResource\Http\Requests\Employee\EmployeeUpdateRequest;
use Modules\HumanResource\Transformers\Employee\EmployeeDTResource;
use Modules\HumanResource\Transformers\Employee\EmployeeListResource;

class EmployeeController extends Controller
{

    public function lists(Request $request)
    {
        $employees = HR_Employee::query();

        if($request->has('search')){
            $q = strtolower($request->input('search'));
            $employees->whereRaw("LOWER(`name`) LIKE '%{$q}%' ");
        }

        if($request->has('liaison')){
            $employees->liaison();
        }

        $data = EmployeeListResource::collection($employees->onlyDivision()->get());

        return response()->json($data);
    }

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
        return view('humanresource::employee.create.index', [
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
        if($request->post('account') == 'manual'){
            $username = $request->post('username');
            $password = bcrypt($request->post('password'));
        }else{
            $username = name_to_username($this->post('firstname'), $this->post('lastname'));
            $password = bcrypt($this->post('password'));
        }

        $account = Account::create([
            'employee_id' => $employee->id,
            'username' => $username,
            'password' => $password
        ]);

        return response()->json(['message' => 'Employee has been registered.']);
    }

    public function edit($id)
    {
        $employee = HR_Employee::with('position', 'division.office', 'account')->findOrFail($id);

        return view('humanresource::employee.edit.index', [
            'employee' => $employee
        ]);
    }

    public function update(EmployeeUpdateRequest $request, HR_Employee $employee)
    {
     
        $reload = false;

        switch($request->header('X-Edit-Employee')){

            case 'information': 
                // checking if request has file
                if($request->hasFile('profile_avatar')){

                    $file = $request->file('profile_avatar');
                    $path = $file->store('public/employees/profile');
                    $image_name = str_replace('public/employees/profile/', '', $path);

                    $current_image = $employee->info['image'];

                    if($current_image != null){
                        unlink(storage_path("app/public/employees/profile/".$current_image));
                    }

                    $reload = true;

                }else{
                    $image_name = $employee->info['image'];
                }

                $employee->update([
                    'name->fname' => $request->post('firstname'),
                    'name->lname' => $request->post('lastname'),
                    'name->mname' => $request->post('middlename'),
                    'name->sname' => $request->post('namesuffix'),
                    'name->title' => $request->post('nametitle'),

                    'info->gender' => $request->post('sex'),
                    'info->birthday' => $request->post('birthday'),
                    'info->address' => $request->post('address'),
                    'info->civilStatus' => $request->post('civil'),
                    'info->phoneNumber' => $request->post('phone'),
                    'info->image' => $image_name
                ]);

            break;
            
            case 'employment': 
                $employee->update([

                    'division_id' => $request->post('division'),
                    'position_id' => $request->post('position'),
                    'card' => $request->post('card'),

                    'employment->type' => $request->post('appointment'),

                    'liaison' => ($request->has('liaison')) ? true : false

                ]);
            break;

            case 'credentials':

                $fields['username'] = $request->post('username');

                // checking if password is set
                if($request->post('password') != ''){
                   $fields['password'] = bcrypt($request->post('password'));
                }

                $employee->account()->update($fields);

            break;

            default:
                return response()->json(['message' => 'Cannot identify request header.'], 422);
            break;

        }

        return response()->json(['message' => 'Employee has been updated.', 'reload' => $reload]);
    }
}
