<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Traits\HasRoles;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
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
    }
    /**
     * Get the post-login redirect path for the user based on their role.
     *
     * @return string
     */
    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }
    public function adminLogin()
    {
        $credentials = request()->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Kiểm tra xem người dùng có vai trò là admin không
            if (auth()->user()->hasRole('admin')) {
                // Đăng nhập thành công với vai trò admin, chuyển hướng đến trang admin
                return redirect()->route('dashboard'); // Thay 'admin.dashboard' bằng tên thật của route admin dashboard
            }

            // Nếu không phải admin, đăng xuất và thông báo lỗi
            Auth::logout();
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập trang admin.');
        }

        // Đăng nhập không thành công, thông báo lỗi
        return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    public function adminLogout()
    {
        Auth::logout();
        return route('admin.login');
    }
    public function redirectTo()
    {
        // Check the role of the authenticated user
        if (auth()->user()->hasRole('admin')) {
            return route('dashboard');
        } else {
            return RouteServiceProvider::HOME;
        }
    }
}
