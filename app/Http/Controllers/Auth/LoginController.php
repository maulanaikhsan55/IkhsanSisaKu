<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try login with username or email
        $loginType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            if ($user->isKarangTaruna() && $user->karangTaruna) {
                if ($user->karangTaruna->status === 'nonaktif') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Akun karang taruna Anda telah dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.',
                    ])->onlyInput('email');
                }
            }

            $request->session()->regenerate();
            $user->updateLastLogin();

            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'email' => 'Username/email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Berhasil logout.');
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    protected function redirectToDashboard()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->isKarangTaruna()) {
            return redirect()->route('karang-taruna.dashboard');
        }

        return redirect()->route('welcome');
    }
}