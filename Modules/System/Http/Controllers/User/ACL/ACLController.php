<?php

namespace Modules\System\Http\Controllers\User\ACL;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\SYS_User;
use Spatie\Permission\Models\Permission;

class ACLController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->sortBy('name');
        // $user = SYS_User::find(Auth::user()->id);
        // $user->givePermissionTo('fms-edit-document');
        return view('system::user.acl.index',[
            "permissions" => $permissions
        ]);
    }

    public function show($id)
    {
        $user = SYS_User::with('employee')->findOrFail($id);
        $permissions = Permission::get();

        return view('system::user.permissions', [
            'user' => $user,
            'permissions' => $permissions
        ]);

    }

    public function store(Request $request, $id)
    {
        $user = SYS_User::find($id);

        foreach($request->permissions as $permission){
            $user->givePermissionTo($permission);
        }

        return redirect()->back()->with('alert-success', 'Permissions has been granted.');
    }
}
