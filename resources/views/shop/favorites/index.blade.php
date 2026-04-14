<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Favorites</title>
    @include('layouts.head')
    @vite(['resources/js/shop/products-loader.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-slate-100">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 w-full">

            <div class="pt-14 pb-10">
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-2">
                    My <span class="text-blue-600">Favorites</span>
                </h1>
                <p class="text-slate-500 text-base font-normal">
                    Products you saved for later. Keep track of what you love.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 mb-10">

                <form method="GET" action="{{ route('products.favorites.index') }}" class="flex-1 min-w-[260px]">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search in favorites..."
                            class="w-full h-13 pl-11 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder-slate-400 outline-none shadow-sm transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-red-500/10">
                    </div>
                </form>

                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="h-13 flex items-center gap-2 px-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-blue-500 hover:text-blue-600 hover:bg-red-50"
                        :class="open ? 'border-blue-500 text-blue-600 bg-red-50 ring-4 ring-red-500/10' : ''">
                        <i class="fa-solid fa-layer-group text-blue-500 text-xs"></i>
                        Categories
                        <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0" style="display:none;"
                        class="absolute z-50 mt-2 left-0 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl p-2">
                        
                        <a href="{{ route('products.favorites.index', ['category' => 'all'] + request()->except('category', 'page')) }}"
                            class="flex items-center justify-between px-4 py-2.5 text-sm {{ request('category') == 'all' || !request('category') ? 'font-bold text-blue-600 bg-red-50' : 'font-medium text-slate-600' }} rounded-xl">
                            All Categories
                            @if(request('category') == 'all' || !request('category')) <i class="fa-solid fa-check text-[10px]"></i> @endif
                        </a>

                        @foreach ($categories as $category)
                            <a href="{{ route('products.favorites.index', ['category' => $category->id] + request()->except('category', 'page')) }}"
                                class="flex items-center justify-between px-4 py-2.5 text-sm {{ request('category') == $category->id ? 'font-bold text-blue-600 bg-red-50' : 'font-medium text-slate-600 hover:bg-slate-50' }} rounded-xl transition-colors duration-100">
                                {{ $category->name }}
                                @if(request('category') == $category->id) <i class="fa-solid fa-check text-[10px]"></i> @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="h-13 flex items-center gap-2 px-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-blue-500 hover:text-blue-600 hover:bg-red-50"
                        :class="open ? 'border-blue-500 text-blue-600 bg-red-50 ring-4 ring-red-500/10' : ''">
                        <i class="fa-solid fa-arrow-up-wide-short text-blue-500 text-xs"></i>
                        Sort By
                        <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0" style="display:none;"
                        class="absolute z-50 mt-2 right-0 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl p-2">
                        
                        @php
                            $sortOptions = [
                                'latest' => 'Latest Arrivals',
                                'rating' => 'Top Rated',
                                'price_asc' => 'Price: Low to High',
                                'price_desc' => 'Price: High to Low'
                            ];
                            $currentSort = request('sort', 'latest');
                        @endphp

                        @foreach($sortOptions as $key => $label)
                            <a href="{{ route('products.favorites.index', ['sort' => $key] + request()->except('sort', 'page')) }}"
                                class="flex items-center justify-between px-4 py-2.5 text-sm {{ $currentSort == $key ? 'font-bold text-blue-600 bg-red-50' : 'font-medium text-slate-600 hover:bg-slate-50' }} rounded-xl transition-colors duration-100">
                                {{ $label }}
                                @if($currentSort == $key) <i class="fa-solid fa-check text-[10px]"></i> @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @if($products->isNotEmpty())
                    @include('shop.products.partials.products', ['products' => $products])
                @endif
            </div>

            @if($products->isEmpty())
                <div class="text-center py-24 bg-white rounded-3xl border border-dashed border-slate-200 shadow-sm mt-5">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5">
                        <i class="fa-regular fa-heart text-3xl"></i>
                    </div>
                    <p class="text-xl font-bold text-slate-800">No favorites found</p>
                    <p class="text-slate-500 mt-2 max-w-xs mx-auto">
                        @if(request()->anyFilled(['search', 'category']))
                            Try adjusting your filters to find what you're looking for.
                        @else
                            Start adding products you love to your list!
                        @endif
                    </p>
                    <a href="{{ route('shop.products.index') }}" class="inline-flex mt-8 px-8 py-3 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all active:scale-95">
                        Browse Products
                    </a>
                </div>
            @endif

            @if ($products->hasMorePages())
                <div class="text-center mt-16 mb-12">
                    <button id="load-more-btn" data-url="{{ $products->nextPageUrl() }}"
                        class="inline-flex items-center gap-2.5 px-10 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 shadow-sm transition-all duration-200 hover:border-red-500 hover:text-red-600 hover:bg-red-50 hover:ring-4 hover:ring-red-500/10 active:scale-95">
                        <i class="fa-solid fa-plus text-[11px]"></i>
                        Show More Favorites
                    </button>
                </div>
            @endif

            <div class="h-16"></div>
        </div>
    </main>

    @include('layouts.footer')

</body>
</html>