<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SpecificModuleDivision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $division_id)
    {
        if(authenticated()->employee->division_id == $division_id || authenticated()->can('sys.sudo')){
            return $next($request);
        }

        abort(403);
    }
}
