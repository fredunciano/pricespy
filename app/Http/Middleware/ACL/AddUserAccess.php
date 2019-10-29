<?php

namespace App\Http\Middleware\ACL;

use Closure;

class AddUserAccess
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
        if (auth()->user()->is_sub) {
            if (auth()->user()->permissions->add_new_sub_user) {
                return $next($request);
            } else {
                return back()->with('error', 'access_denied');
            }
        } else {
            return $next($request);
        }
    }
}
