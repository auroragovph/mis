<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Account;
use Modules\System\Http\Requests\Profile\CredentialRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('system::profile.index');
    }

    public function information(Request $request)
    {
        $user = HR_Employee::find(auth()->user()->employee_id);

        $user->update([
            'info->phoneNumber' => $request->post('phone'),
            'info->address' => $request->post('address')
        ]);


        return redirect()
            ->back()
            ->with('alert-success', 'Profile information has been updated.');
    }

    public function credentials(CredentialRequest $request)
    {
        
        if(!Hash::check($request->post('password_old'), auth()->user()->password)){

            return redirect()
                    ->back()
                    ->with('alert-error', 'Password mismatch');
        }

        $account = Account::find(auth()->id());

        $account->update([
            'password' => Hash::make($request->post('password'))
        ]);

        return redirect()
                ->back()
                ->with('alert-success', 'Password has been changed.');
    }
}
