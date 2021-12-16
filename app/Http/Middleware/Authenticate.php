<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('main.index');
        }
    }

    public function handle($request, Closure $next, $guard = null)
    {

        if (auth()->user() == null) {

            return redirect()->route('main.index')->with('alert_messages', __('auth.not_login_user'));
        }

        //dd($request);

        return $next($request);
    }
}
