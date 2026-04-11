<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials,$request->filled('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if (!$user->email_verified_at) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Please verify your email before logging in.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $role = $user->role->name;

        if ($role === 'seller') {
            if (!$user->store()->exists()) {
                return redirect()->route('seller.store.setup');
            }
            return redirect()->route('seller.store.index');
        }

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
