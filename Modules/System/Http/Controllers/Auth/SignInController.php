<?php

namespace Modules\System\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Modules\System\Entities\SYS_User;

class SignInController extends Controller
{
   
    use ThrottlesLogins;

    protected $maxAttempts = 3;
    protected $decayMinutes = 1;
    protected $username = 'username';

    public function form()
    {

        // checking if already login
        if(Auth::check()){
            return redirect('/home');
        }

        return view('system::auth.signin');
    }

    public function username()
    {
        return $this->username;
    }

    public function authenticate(Request $request)
    {

        if(Auth::check()){
            $response['message'] = 'Already authenticated';
            return response()->json($response, 400);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }


        // checking if new account
        $checkAccountStatus = SYS_User::where('username', $request->post('username'))->first();

        if(!$checkAccountStatus){
            $this->incrementLoginAttempts($request);
            return response()->json(['message' => 'We cannot find your credentials in our database.'], 406);
        }


        if(array_key_exists('firstLogin', $checkAccountStatus->properties['auth'])){

            if (Auth::attempt(['username' => $request->username, 'password' => sha1($request->password), 'status' => 1])) {
                $this->clearLoginAttempts($request);

                $checkAccountStatus->update([
                    'properties->auth->lastLogin' => now()->format('Y-m-d h:i A')
                ]);
                
                session(['sys.password' => $request->password]);
                return response()->json(['message' => 'Success Login', 'route' => route('sp.login.first')], 200);
            }
        }


        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1])) {
            $this->clearLoginAttempts($request);

            $checkAccountStatus->update([
                'properties->auth->lastLogin' => now()->format('Y-m-d h:i A')
            ]);

            return response()->json(['message' => 'Success Login', 'route' => route('root.home')], 200);
        }

        $this->incrementLoginAttempts($request);

        return response()->json(['message' => 'We cannot find your credentials in our database.'], 406);
    }

    public function logout()
    {
        if(Auth::check()){

            $user = SYS_User::find(Auth::user()->id);

            $user->update([
                'properties->auth->lastLogout' => now()->format('Y-m-d h:i A')
            ]);

           Auth::logout();
        }

        return redirect('auth/signin');
    }
}
