<?php

namespace App\Http\Middleware;

use Closure;
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
        if($request->user()->can('godmode')){
            return $next($request);
            
        }

        if($document->division_id !== $request->user()->employee->division_id){
            abort(403);
        }


        return $next($request);


    }
}
