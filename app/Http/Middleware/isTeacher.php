<?php

namespace App\Http\Middleware;

use Closure;

class isTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth_teacher()->user()) {
         
            return redirect()->to(route('auth.teacher.loginForm'));
        }
        return $next($request);
    }
}
