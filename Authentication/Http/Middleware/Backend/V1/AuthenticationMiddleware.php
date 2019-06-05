<?php

namespace Modules\Authentication\Http\Middleware\Backend\V1;

use Closure;
use Illuminate\Http\Request;

class AuthenticationMiddleware
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
        if (! auth()->check()) {
            $parameters['redirect_back_url'] = url()->full();
            return redirect()->route('modules.authentication.backend.v1.authentication.login.index', $parameters);
        }

        return $next($request);
    }
}
