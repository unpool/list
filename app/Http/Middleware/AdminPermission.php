<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;

class AdminPermission
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
        /** @var Admin $admin */
        $admin = auth_admin()->user();

        if (is_null($admin)) {
//            if($admin->hasPermissionTo(get_permission_name($routeName, 'admin'))) {
            return $next($request);
//            }
        }

        return redirect()->to(route('auth.admin.login'));
    }
}
