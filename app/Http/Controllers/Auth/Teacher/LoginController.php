<?php

namespace App\Http\Controllers\Auth\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/teacher/dashboard';

    protected $loginPath = '/teacher/login';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest:teacher')->except('logout');
    }

    /**
     * @return View
     */
    public function loginForm():View
    {
        return view('auth.teacher.login');
    }

    /**
     * @param Admin $request
     * @return RedirectResponse
     */
    public function login(Admin $request):RedirectResponse
    {
        $usernameAndPassword = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (auth('teacher')->validate($usernameAndPassword)) {
            // first check this information from username and password exist in database
            if (auth('teacher')->attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ], $request->has('remember'))
            ) {
                return redirect()->intended(route('teacher.dashboard'));
            }
        }
        session()->flash('alert', [
            'status' => false,
            'type' => 'danger',
            'message' => 'خطا در نام کاربری یا گذرواژه'
        ]);


        return redirect()->route('auth.teacher.login')->withInput($request->except('password'));
    }


    public function logout():RedirectResponse
    {
        auth('teacher')->logout();
        return redirect()->to(route('welcome'));
    }
}
