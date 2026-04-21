<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->email_verified_at) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->route('auth.verify.form')
                    ->with('success', 'We sent a verification code to your email.');
            } else {
                return back()->withErrors([
                    'email' => 'Invalid email or password.',
                ]);
            }
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ]);
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
