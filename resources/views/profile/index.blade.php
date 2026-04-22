<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    @include('layouts.head')
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    @include('layouts.header')
    @include('layouts.notifications')

<main class="max-w-6xl mx-auto px-4 py-6 w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <div class="lg:col-span-4">
            <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm text-center sticky top-6">
                <div class="w-24 h-24 bg-indigo-600 text-white text-3xl font-black flex items-center justify-center rounded-full mx-auto mb-4 shadow-xl ring-8 ring-indigo-50">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500 mb-6 font-medium">{{ $user->email }}</p>

                <div class="flex flex-col gap-2 mb-8">
                    <div class="inline-flex mx-auto px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                        {{ $user->role->name ?? 'Standard Member' }}
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium">Joined {{ $user->created_at->format('F Y') }}</span>
                </div>

                <button onclick="toggleModal('edit-profile-modal')"
                    class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200 active:scale-95">
                    Update Profile Settings
                </button>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ([
                    ['label' => 'Favorites', 'count' => $stats['favorites'], 'icon' => 'fa-heart', 'color' => 'bg-rose-50 text-rose-500 border-rose-100'],
                    ['label' => 'Interests', 'count' => $stats['interests'], 'icon' => 'fa-star', 'color' => 'bg-amber-50 text-amber-500 border-amber-100'],
                    ['label' => 'Reports', 'count' => $stats['reports'], 'icon' => 'fa-flag', 'color' => 'bg-slate-50 text-slate-500 border-slate-100']
                ] as $stat)
                    <div class="bg-white p-5 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4 hover:border-indigo-200 transition-colors">
                        <div class="w-12 h-12 {{ $stat['color'] }} rounded-2xl flex items-center justify-center text-lg border">
                            <i class="fa-solid {{ $stat['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900 tracking-tighter">{{ $stat['count'] }}</div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="font-black text-slate-800 tracking-tight">Account Overview</h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Full Registered Name</label>
                            <p class="text-slate-700 font-bold">{{ $user->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Primary Email Address</label>
                            <p class="text-slate-700 font-bold">{{ $user->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Account Status</label>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                <span class="text-emerald-600 font-bold text-sm text-sm uppercase tracking-tighter">Verified & Active</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Last Profile Update</label>
                            <p class="text-slate-500 text-sm font-medium italic">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

    <div id="edit-profile-modal"
        class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-slate-900 text-lg tracking-tight">Edit Personal Information</h3>
                <button onclick="toggleModal('edit-profile-modal')"
                    class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="p-8">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">New
                                Password</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Confirm
                                New</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <label class="block text-sm font-bold text-rose-600 mb-2 ml-1 italic">Enter Current Password to
                            Save</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-3 bg-rose-50/30 border border-rose-100 rounded-xl focus:ring-2 focus:ring-rose-500/20 outline-none transition-all placeholder:text-rose-300">
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-8 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                    Confirm & Save Changes
                </button>
            </form>
        </div>
    </div>

    @include('layouts.footer')
    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
</body>

</html>
