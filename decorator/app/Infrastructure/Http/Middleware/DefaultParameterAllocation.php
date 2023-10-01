<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DefaultParameterAllocation
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Step 3: Ignore default route parameters in controller methods entrance parameters
        $request->route()->forgetParameter('web_guard');
        $request->route()->forgetParameter('api_guard');
        $request->route()->forgetParameter('api_client_guard');
        $request->route()->forgetParameter('api_version');

        return $next($request);
    }
}
