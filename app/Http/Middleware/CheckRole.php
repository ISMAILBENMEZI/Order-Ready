<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // if (Auth::guest()) {
        //     return redirect()->route('auth.login');
        // }

        $user = $request->user();

        if (!$user || !$user->role) {
            abort(403, 'Unauthorized access.');
        }

        if (!in_array($user->role->name, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }
        return $next($request);
    }
}
