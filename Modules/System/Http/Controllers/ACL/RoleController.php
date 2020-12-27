<?php

namespace Modules\System\Http\Controllers\ACL;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Transformers\ACL\RoleResource;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function lists(Request $request)
    {
        $roles = ($request->has('search')) ? Role::where('name', 'like', '%'.$request->input('search').'%')->get() : Role::get();
        return RoleResource::collection($roles);
    }

    public function index()
    {
        return view('system::acl.role.index');
    }
}
