<?php

namespace Modules\System\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Http\Requests\Account\ACLUpdateRequest;
use Modules\System\Transformers\AccountDTResource;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return AccountDTResource::collection(Account::with('employee.position', 'employee.division.office')->get());
        }
        return view('system::accounts.index');
    }

    public function acl(ACLUpdateRequest $request, Account $account)
    {
        // updating role
        $account->syncRoles([$request->post('role')]);

        // updating permissions
        $permissions = collect($request->post('permissions'))->diff($account->getPermissionsViaRoles()->pluck('name')->toArray())->toArray();
        $account->syncPermissions($permissions);

        return response(['message' => 'Access has been updated']);
    }
}
