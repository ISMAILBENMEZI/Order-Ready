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

        if ($user && Hash::check($request->password, $user->password)) {

            if ($user->status === 'disabled') {
                return redirect()->route('auth.banned')
                    ->with([
                        'name' => $user->name,
                        'email' => $user->email
                    ]);
            }

            if (!$user->email_verified_at) {
                Auth::login($user);
                return redirect()->route('auth.verify.form')
                    ->with('success', 'We sent a verification code to your email.');
            }

            Auth::login($user);
            $request->session()->regenerate();

            $role = $user->role->name;
            if ($role === 'seller') {
                return $user->store()->exists()
                    ? redirect()->route('seller.store.index')
                    : redirect()->route('seller.store.setup');
            }

            return $role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
