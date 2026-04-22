<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $allowedRoleIds = Role::whereIn('name', ['admin', 'customer'])->pluck('id');

        $query = User::with('role')->whereIn('role_id', $allowedRoleIds);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);
        $availableRoles = Role::whereIn('name', ['admin', 'customer'])->get();

        return view('admin.users.index', compact('users', 'availableRoles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $allowedRoleIds = Role::whereIn('name', ['admin', 'customer'])->pluck('id')->toArray();
        $request->validate([
            'role_id' => 'required|in:' . implode(',', $allowedRoleIds),
        ]);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot change your own role!');
        }

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'User role updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot disable your own account!');
        }

        $user->status = ($user->status == 'active') ? 'disabled' : 'active';
        $user->save();
        return back()->with('success', "User status updated to {$user->status} successfully.");
    }
}
