<?php

namespace Modules\System\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirstLoginOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!array_key_exists('firstLogin', auth()->user()->properties['auth'])){return abort(404);}
        return $next($request);
    }
}
