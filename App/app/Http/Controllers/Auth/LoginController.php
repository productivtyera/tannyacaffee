<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Show the cashier login form.
     */
    public function showCashierLoginForm()
    {
        return view('auth.cashier-login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginField => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $user = Auth::user();

            if ($request->is('login')) {
                if ($user->role !== 'admin') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    throw ValidationException::withMessages([
                        'login' => ['Anda tidak memiliki akses sebagai Admin.'],
                    ]);
                }
            } elseif ($request->is('cashier/login')) {
                if ($user->role !== 'cashier') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    throw ValidationException::withMessages([
                        'login' => ['Anda tidak memiliki akses sebagai Kasir.'],
                    ]);
                }
            } elseif ($user->role === 'customer') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'login' => ['Anda tidak memiliki akses untuk masuk ke halaman ini.'],
                ]);
            }

            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'cashier') {
                return redirect()->intended(route('cashier.dashboard'));
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
