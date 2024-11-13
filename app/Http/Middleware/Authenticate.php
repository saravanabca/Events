<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }

    
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return url('/');
        }
    }

    public function handle($request, Closure $next, ...$guards)
{
    if ($this->auth->guard('web')->check()) {
        return $next($request);
    }

    return redirect('/');
}
}
