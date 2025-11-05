<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocalLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        if(is_null(session('locale')))
//            session(['locale'=> 'en']); // set language english if language is not set in session
        if (!session()->has('locale')) {
//            session(['locale' => 'en']);
            session()->put('locale','en');
        }

        app()->setLocale(session('locale')); // set the session's language to our application

        return $next($request);
    }
}
