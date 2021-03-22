<?php

namespace Modules\HumanResource\Http\Middleware\Employee;

use Closure;
use Illuminate\Http\Request;

class EditCheckHeaders
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
        $valid_header_value = ['information', 'credentials', 'employment'];

        if(!in_array($request->header('X-Edit-Employee'), $valid_header_value)){
            return response()->json(['message' => 'Invalid/missing header'], 422);
        }

        return $next($request);
    }
}
