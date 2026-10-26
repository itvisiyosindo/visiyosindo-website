<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['id', 'en'];

        // Determine locale from session, cookie, or default 'id'
        $locale = $request->session()->get('locale') 
            ?? $request->cookie('locale') 
            ?? config('app.locale', 'id');

        if (!in_array($locale, $supportedLocales, true)) {
            $locale = 'id';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
