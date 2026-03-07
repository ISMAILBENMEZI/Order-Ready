<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\Auth\VerifyEmailCodeMail;

class RegisteredUserController extends Controller
{
    public function showRegister()
    {
        $roles = Role::whereIn('name', ['seller', 'customer'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'email_verification_code' => $code,
            'email_verification_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new VerifyEmailCodeMail($code));

        session([
            'verify_user_id' => $user->id,
            'intended_url' => url()->previous(),
        ]);

        return redirect()->route('auth.verify.from')
            ->with('success', 'We sent a verification code to your email.');
    }

    public function showVerifyFrom()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = session('verify_user_id');

        if (!$userId) {
            return redirect()->route('regisetr')->with('error', 'Verification session expired.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->with('error', 'User not found.');
        }

        if ($user->email_verification_expires_at < now()) {
            return back()->withErrors([
                'code' => 'The verification code has expired.',

            ]);
        }

        if ($user->email_verification_code !== $request->code) {
            return back()->withErrors([
                'code' => 'The verification code is incorrect.',
            ]);
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'email_verification_expires_at' => null,
        ]);

        Auth::login($user);

        return redirect(session('intended_url', '/'));
    }
}
