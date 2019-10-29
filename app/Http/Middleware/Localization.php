<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class Localization
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
        if ( \Session::has('locale')) {
            \App::setLocale(\Session::get('locale'));
            Carbon::setLocale(\Session::get('locale'));
        } elseif(\Auth::check() == true) {
            $value = auth()->user()->locale;
            \Session::put('locale', $value);
            \App::setLocale(\Session::get('locale'));
            Carbon::setLocale(\Session::get('locale'));
        }

        return $next($request);
    }
}
