<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use App\Models\Teacher;

class TeacherPermission
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


        /** @var Teacher $teacher */
        $teacher = auth_teacher()->user();
        $routeName = Route::current()->getName();


        if (!is_null($teacher)) {

            if ($teacher->hasPermissionTo(get_permission_name($routeName, 'teacher'))) {


            }
        }

        return redirect()->back()->with([
            'error' => get_message('error.permission')
        ]);
    }
}
