<?php

namespace Modules\System\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\System\Entities\Account;
use App\Providers\RouteServiceProvider;
use Modules\System\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('system::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        // $route = (password_verify($request->input('password'), bcrypt('user123'))) ? route('sp.login.first') : route('dashboard');
        
        // saving into sessions
        $authenticated = Account::with('employee.position', 'employee.division.office')->find(auth()->user()->id);
        $request->session()->put('authenticated', $authenticated);

        // return redirect($route);        
        return redirect(session()->pull('url.intended', route('dashboard')));        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
