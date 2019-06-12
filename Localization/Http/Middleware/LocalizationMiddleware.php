<?php

namespace Modules\Localization\Http\Middleware;

use Closure;

class LocalizationMiddleware
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
        $locale = false;
        $locales = array_keys(config('cms.locales'));

        if ($request->expectsJson()) {
            $locale = $request->header('Accept-Language', $locale);
        } else {
            $locale = $request->session()->get('locale') ? $request->session()->get('locale') : $locale;
        }

        if (in_array($locale, $locales)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
