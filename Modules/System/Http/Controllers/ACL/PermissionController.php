<?php

namespace Modules\System\Http\Controllers\ACL;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Transformers\ACL\PermissionResource;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function lists(Request $request)
    {
        $permissions = ($request->has('search')) ? Permission::where('name', 'like', '%'.$request->input('search').'%')->get() : Permission::get();
        return PermissionResource::collection($permissions);
    }
}
