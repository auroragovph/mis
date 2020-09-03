<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\FileManagement\Entities\Document\FMS_Document;

class CheckDocumentIfBelongsToYourDivision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $document = FMS_Document::find((int)$request->route('id'));

        // check the permission of SUPER ADMIN
        if(Auth::user()->can('sys.sudo')){
            return $next($request);
            
        }

        if($document->division_id !== Auth::user()->employee->division_id){
            abort(403);
        }


        return $next($request);


    }
}
