<?php

namespace Modules\General\Http\Controllers;

use App\Models\Account;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\General\Http\Requests\Profile\CredentialUpdateRequest;
use Modules\System\Entities\SYS_ActivityLog;

class ProfileController extends Controller
{
    public function index()
    {
        $logs = SYS_ActivityLog::self()->get()->take(10);

        return view('general::profile.index', [
            'logs' => $logs
        ]);
    }

    public function credentials(CredentialUpdateRequest $request)
    {
        if(!Hash::check($request->post('password_old'), authenticated()->password)){
            return redirect()->back()->with('alert-error', 'You input incorrect password');
        }

        $account = Account::find(authenticated()->id);
        $account->password = Hash::make($request->post('password'));
        $account->save();
        return redirect()->back()->with('alert-success', 'Password has been updated.');
    }
}
