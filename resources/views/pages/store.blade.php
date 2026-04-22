<!DOCTYPE html>
<html lang="en">

<head>
    <title>Explore Stores | Project Name</title>
    @include('layouts.head')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .store-card {
            transition: border-color 0.2s ease, shadow 0.2s ease;
        }

        .store-card:hover {
            border-color: #6366f1;
        }

        .banner-container {
            aspect-ratio: 3 / 1;
            width: 100%;
            background: #f1f5f9;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-slate-50 antialiased text-slate-900">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Marketplace Stores</h1>
                <p class="text-slate-500 mt-2 font-medium">Browse verified sellers and their collections</p>
            </div>

            <form method="GET" action="{{ route('stores') }}" class="flex items-center gap-2">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400 group-focus-within:text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Store name..."
                        class="block w-full md:w-64 pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
                <button type="submit"
                    class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all active:scale-95">
                    Search
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @forelse ($stores as $store)
                <div
                    class="store-card group bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col overflow-hidden">

                    <div class="banner-container relative flex-shrink-0">
                        @if ($store->banner_url)
                            <img src="{{ asset('storage/' . $store->banner_url) }}" alt="{{ $store->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200"></div>
                        @endif
                    </div>

                    <div class="relative px-5 h-8">
                        <div class="absolute -top-10 left-5">
                            <div
                                class="w-16 h-16 rounded-2xl border-4 border-white bg-white shadow-md overflow-hidden flex items-center justify-center">
                                <img src="{{ asset('storage/' . $store->logo_url) }}" alt="logo"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <div class="mb-4">
                            <h3
                                class="font-bold text-slate-900 text-lg group-hover:text-indigo-600 transition-colors truncate">
                                {{ $store->name }}
                            </h3>
                            <p class="text-slate-500 text-xs leading-relaxed mt-2 line-clamp-2 h-8">
                                {{ $store->description ?? 'No description available for this store.' }}
                            </p>
                        </div>

                        <div class="mt-auto pt-4 border-t border-slate-50">
                            <a href="{{ route('shop.stores.show', $store) }}"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 bg-slate-50 hover:bg-indigo-600 hover:text-white text-slate-700 text-xs font-extrabold rounded-xl transition-all">
                                Open Store
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div
                    class="col-span-full py-32 bg-white rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center">
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mb-4">
                        <i class="fa-solid fa-store-slash"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">No stores found</h3>
                    <p class="text-slate-400 mt-1">Try checking your spelling or search for something else.</p>
                </div>
            @endforelse

        </div>

        @if ($stores->hasPages())
            <div class="mt-16 flex justify-center">
                <div class="bg-white px-4 py-2 rounded-2xl border border-slate-200 shadow-sm">
                    {{ $stores->appends(['search' => $search])->links() }}
                </div>
            </div>
        @endif

    </main>

    @include('layouts.footer')

</body>

</html>
