<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>User Management</title>
    @include('layouts.head')
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')
    @include('layouts.notifications')

    <main class="max-w-7xl mx-auto px-4 py-10 w-full">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">User Management</h1>
                <p class="text-sm text-slate-500">Manage roles and permissions for admins and customers</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                Back to Dashboard
            </a>
        </div>

        <div class="mb-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full max-w-md px-4 py-2 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors">
                    Search
                </button>
            </form>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Current Role
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-[10px] font-bold uppercase ring-1 
                                    {{ $user->role->name == 'admin' ? 'bg-purple-50 text-purple-600 ring-purple-100' : 'bg-slate-50 text-slate-600 ring-slate-100' }}">
                                    {{ $user->role->name ?? 'No Role' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-full text-[10px] font-bold uppercase transition-all ring-1
                                            {{ $user->status == 'active'
                                                ? 'bg-emerald-50 text-emerald-600 ring-emerald-100 hover:bg-emerald-100'
                                                : 'bg-rose-50 text-rose-600 ring-rose-100 hover:bg-rose-100' }}">
                                        {{ $user->status }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST"
                                    class="flex items-center justify-center gap-2">
                                    @csrf
                                    <select name="role_id"
                                        class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold outline-none focus:ring-2 focus:ring-blue-500/10">
                                        @foreach ($availableRoles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="px-4 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-blue-600 transition-all">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>
