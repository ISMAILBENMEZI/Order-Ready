<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    @include('layouts.head')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-anim {
            animation: slideUp 0.5s ease-out forwards;
            opacity: 0;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')

    <main class="flex-grow">
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-gauge-high text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">System Overview</h1>
                        <p class="text-xs text-slate-500">Platform performance and stats</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.reports') }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-file-contract text-slate-400"></i>
                        Reports
                    </a>
                    <a href="" 
                       class="flex items-center gap-2 px-4 py-2 bg-blue-600 rounded-lg text-sm font-semibold text-white hover:bg-blue-700 shadow-sm transition-all">
                        <i class="fa-solid fa-user-shield"></i>
                        Change Roles
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-5 bg-blue-600 rounded-full"></span>
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Main Metrics</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="stat-card card-anim delay-1 bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-lg bg-slate-100 text-slate-600">
                                <i class="fa-solid fa-users text-lg"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 border border-slate-100 px-2 py-0.5 rounded">Total</span>
                        </div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Users</h3>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($usersCount) }}</p>
                    </div>

                    <div class="stat-card card-anim delay-2 bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-lg bg-amber-50 text-amber-600">
                                <i class="fa-solid fa-store text-lg"></i>
                            </div>
                        </div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase mb-1">Active Stores</h3>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($storesCount) }}</p>
                    </div>

                    <div class="stat-card card-anim delay-3 bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-lg bg-violet-50 text-violet-600">
                                <i class="fa-solid fa-user-tie text-lg"></i>
                            </div>
                        </div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase mb-1">Sellers</h3>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($sellersCount) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-4">
                    <div class="bg-white p-5 rounded-xl border border-slate-200 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Active Items</p>
                            <p class="text-lg font-bold text-slate-900">{{ number_format($activeProducts) }}</p>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-slate-200 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Banned Items</p>
                            <p class="text-lg font-bold text-slate-900">{{ number_format($bannedProducts) }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-6 uppercase tracking-wider">Product Status</h3>
                    
                    @php
                        $total = $productsCount > 0 ? $productsCount : 1;
                        $activePct = ($activeProducts / $total) * 100;
                        $bannedPct = ($bannedProducts / $total) * 100;
                    @endphp

                    <div class="space-y-5">
                        <div>
                            <div class="flex justify-between text-xs font-semibold mb-2">
                                <span class="text-emerald-600">Active ({{ round($activePct, 1) }}%)</span>
                                <span class="text-slate-500">{{ $activeProducts }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $activePct }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold mb-2">
                                <span class="text-red-600">Banned ({{ round($bannedPct, 1) }}%)</span>
                                <span class="text-slate-500">{{ $bannedProducts }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full">
                                <div class="h-full bg-red-500 rounded-full" style="width: {{ $bannedPct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>