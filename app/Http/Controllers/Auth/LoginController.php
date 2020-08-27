<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('adminLogout');

    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard('web')->logout();

        $request->session()->invalidate();

        notify()->success('ログアウトしました', '成功');

        return redirect()
            ->route('courses.index');
        
    }

    public function showAdminLoginForm()
    {
        return view('auth.admins.login');
    }

    public function adminLogin(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['account_id' => $request->account_id, 'password' => $request->password])) {

            return redirect()->route('admins.index');
        }
        
        return back()->withInput($request->only('account_id'));
    }

    public function adminLogout(Request $request)
    {
        $this->guard('admin')->logout();

        $request->session()->invalidate();

        notify()->success('管理者ログアウトしました', '成功');

        return redirect()
            ->route('courses.index');
        
    }

    public function username()
    {
        return 'account_id';
    }

    protected function authenticated(Request $request, $user)
    {
        notify()->success('ログインしました', '成功');
        
        if (session()->has('url.intended')) {
            return redirect(session('url.intended'));
        }

        return redirect()
            ->route('courses.index');
    }
}
