<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Store — Statistics</title>
    @include('layouts.head')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05);
        }

        .count-up {
            animation: fadeSlideIn 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-1 {
            animation-delay: 0.1s;
        }

        .card-2 {
            animation-delay: 0.2s;
        }

        .card-3 {
            animation-delay: 0.3s;
        }

        .card-4 {
            animation-delay: 0.4s;
        }

        .card-5 {
            animation-delay: 0.5s;
        }

        .card-6 {
            animation-delay: 0.6s;
        }

        .card-7 {
            animation-delay: 0.7s;
        }

        .card-8 {
            animation-delay: 0.8s;
        }

        .card-9 {
            animation-delay: 0.9s;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow">

        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 py-7 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('seller.store.index') }}"
                        class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors flex-shrink-0">
                        <i class="fa-solid fa-arrow-left text-slate-600 text-sm"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Store Statistics</h1>
                        <p class="text-xs font-semibold text-slate-400 mt-0.5">Overview of your store performance</p>
                    </div>
                </div>

                <div
                    class="flex items-center gap-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-xl border border-blue-100">
                    <i class="fa-solid fa-store text-xs"></i>
                    <span class="text-xs font-bold">{{ Auth::user()->store->name }}</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-8 space-y-10">

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-2 h-6 bg-blue-600 rounded-full"></div>
                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-widest">Inventory Status</h2>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="stat-card count-up card-1 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-layer-group text-slate-600 text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Items</p>
                        <p class="text-3xl font-black text-slate-900 leading-none">{{ $totalProducts }}</p>
                    </div>

                    <div class="stat-card count-up card-2 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Available</p>
                        <p class="text-3xl font-black text-slate-900 leading-none">{{ $availableProducts }}</p>
                    </div>

                    <div class="stat-card count-up card-3 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-comments text-blue-500 text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Negotiating</p>
                        <p class="text-3xl font-black text-slate-900 leading-none">{{ $negotiatingProducts }}</p>
                    </div>

                    <div class="stat-card count-up card-4 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-ban text-red-500 text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Sold Out</p>
                        <p class="text-3xl font-black text-slate-900 leading-none">{{ $soldoutProducts }}</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-2 h-6 bg-violet-600 rounded-full"></div>
                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-widest">Store Engagement</h2>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

                    <div class="stat-card count-up card-5 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-user-plus text-violet-500 text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-violet-500 uppercase tracking-wider mb-1">Followers</p>
                        <p class="text-2xl font-black text-slate-900 leading-none">{{ $followers }}</p>
                    </div>

                    <a href="{{ route('seller.store.statistics.interests', Auth::user()->store) }}"
                        class="stat-card block count-up card-6 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-blue-300 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-heart text-amber-500 text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-1">Interests</p>
                        <p class="text-2xl font-black text-slate-900 leading-none mb-2">{{ $interests }}</p>
                        <p class="text-[9px] text-slate-400 font-bold">View details →</p>
                    </a>

                    <a href="{{ route('seller.store.statistics.favorites', Auth::user()->store) }}"
                        class="stat-card block count-up card-7 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-blue-300 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-fire text-rose-500 text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-rose-600 uppercase tracking-wider mb-1">Top Favorite</p>
                        <p class="text-2xl font-black text-slate-900 leading-none mb-2">
                            {{ $topFavoritedProducts ?? 0 }}</p>
                        <p class="text-[9px] text-slate-400 font-bold">Popular →</p>
                    </a>

                    <a href="{{ route('seller.store.statistics.deadProducts', Auth::user()->store) }}" 
                        class="stat-card block count-up card-8 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-blue-300 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-skull text-slate-500 text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Dead Items</p>
                        <p class="text-2xl font-black text-slate-900 leading-none mb-2">{{ $deadProducts->count() }}
                        </p>
                        <p class="text-[9px] text-slate-400 font-bold">Inactive →</p>
                    </a>

                    <a href="{{ route('seller.store.statistics.reports', Auth::user()->store) }}"
                        class="stat-card block count-up card-9 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-blue-300 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-flag text-red-500 text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-red-600 uppercase tracking-wider mb-1">Reports</p>
                        <p class="text-2xl font-black text-slate-900 leading-none mb-1">{{ $reports }}</p>
                        @if ($reports > 0)
                            <span
                                class="text-[8px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full font-bold animate-pulse">Action
                                Needed</span>
                        @else
                            <span class="text-[8px] text-emerald-500 font-bold">Clear</span>
                        @endif
                    </a>

                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Inventory Distribution</h3>
                    <span class="text-xs font-bold text-slate-400">Total: {{ $totalProducts }} Items</span>
                </div>

                @if ($totalProducts > 0)
                    @php
                        $availPct = round(($availableProducts / $totalProducts) * 100);
                        $negoPct = round(($negotiatingProducts / $totalProducts) * 100);
                        $soldPct = 100 - $availPct - $negoPct;
                    @endphp

                    <div class="flex h-4 w-full rounded-full overflow-hidden bg-slate-100 mb-8 p-1 gap-1">
                        <div class="h-full bg-emerald-400 rounded-full transition-all duration-1000"
                            style="width: {{ $availPct }}%"></div>
                        <div class="h-full bg-blue-400 rounded-full transition-all duration-1000"
                            style="width: {{ $negoPct }}%"></div>
                        <div class="h-full bg-red-400 rounded-full transition-all duration-1000"
                            style="width: {{ $soldPct }}%"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="w-3 h-3 rounded-full bg-emerald-400 ring-4 ring-emerald-100"></div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Available</p>
                                <p class="text-lg font-black text-slate-800">{{ $availPct }}%</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="w-3 h-3 rounded-full bg-blue-400 ring-4 ring-blue-100"></div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Negotiating</p>
                                <p class="text-lg font-black text-slate-800">{{ $negoPct }}%</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="w-3 h-3 rounded-full bg-red-400 ring-4 ring-red-100"></div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Sold Out</p>
                                <p class="text-lg font-black text-slate-800">{{ $soldPct }}%</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="py-10 text-center">
                        <i class="fa-solid fa-box-open text-slate-200 text-4xl mb-3"></i>
                        <p class="text-sm text-slate-400 font-semibold">Start adding products to see your store
                            breakdown.</p>
                    </div>
                @endif
            </div>

        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
