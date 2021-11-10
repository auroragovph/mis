<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\System\Entities\Account;
use Modules\System\Http\Requests\Profile\Security\UsernameRequest;
use Modules\System\Http\Requests\Profile\Security\PasswordRequest;


class ProfileController extends Controller
{
    public function index()
    {
        $tab = request()->get('tab');

        return view('system::profile.index',compact('tab'));
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

    public function change_username(UsernameRequest $request)
    {
        $account = Account::findOrFail(auth()->id());
        $account->username = $request->post('username');
        $account->save();

        return response()->json([
            'message' => 'Username has been updated.',
            'intended' => route('sys.profile.index', ['tab' => 'overview'])
        ]);
    }

    public function change_password(PasswordRequest $request)
    {
        
        if(!Hash::check($request->post('password_old'), auth()->user()->password)){

            return response()->json([
                'message' => 'Password mismatch.'
            ], 419);
        }

        $account = Account::find(auth()->id());

        $account->update([
            'password' => Hash::make($request->post('password'))
        ]);

        return response()->json([
            'message' => 'Password has been updated.',
            'intended' => route('sys.profile.index', ['tab' => 'overview'])
        ]);
    }
}
