<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function create($token)
    {
        $email = request('email');

        $reset = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$reset || !Hash::check($token, $reset->token) || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return redirect()->route('auth.login')
                ->with('error', 'This password reset link is invalid or has expired');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function store(ResetPasswordRequest $request)
    {
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors([
                'email' => 'Invalid reset token'
            ]);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return back()->withErrors([
                'email' => 'Reset link expired'
            ]);
        }

        if (!$reset) {
            return back()->withErrors([
                'email' => 'Invalid reset token'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('auth.login')
            ->with('status', 'Password reset successfully');
    }
}
