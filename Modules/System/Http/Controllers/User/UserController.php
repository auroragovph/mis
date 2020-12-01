<?php

namespace Modules\System\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Modules\System\Entities\SYS_User;
use Illuminate\Support\Facades\Session;
use Modules\HumanResource\Entities\HR_Employee;

class UserController extends Controller
{
    public function index()
    {
        $users = SYS_User::with('employee.division.office')->get();
        $employees = HR_Employee::doesntHave('user')->get();
        $roles = Role::get();
        
        return view('system::user.index',[
            "users" => $users,
            "employees" => $employees,
            "roles" => $roles
        ]);
    }

    public function store(Request $request)
    {
        // check username
        $checkUsername = SYS_User::where('username', $request->username)->get()->count();

        if($checkUsername !== 0){
            return response()->json(['message' => 'Username already exists'], 406);
        }


        $user = SYS_User::create([
            "employee_id" => $request->employee,
            "username" => $request->username,
            "password" => password_hash($request->pass, PASSWORD_BCRYPT),
            "status" => 1
        ]);

         // flashing sesssion
         Session::flash('alert-title', 'Success!');
         Session::flash('alert-message', 'User has been created.');
         Session::flash('alert-type', 'success');
         Session::flash('alert-icon', 'fas fa-check');
 

        return response()->json(['message' => 'User has been created.'], 200);

    }
}
