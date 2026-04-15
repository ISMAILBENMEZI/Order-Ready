<!DOCTYPE html>
<html lang="en">

<head>
    <title>Explore Products</title>
    @include('layouts.head')
    @vite(['resources/js/shop/products-loader.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

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
                    Our <span class="text-blue-600">Products</span>
                </h1>
                <p class="text-slate-500 text-base font-normal">
                    Discover the best deals from our trusted sellers.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 mb-10">

                <form method="GET" action="{{ route('shop.products.index') }}" class="flex-1 min-w-[260px]">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search products by name..."
                            class="w-full h-13 pl-11 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder-slate-400 outline-none shadow-sm transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                    </div>
                </form>

                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="h-13 flex items-center gap-2 px-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50"
                        :class="open ? 'border-blue-500 text-blue-600 bg-blue-50 ring-4 ring-blue-500/10' : ''">
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
                        <a href="{{ route('shop.products.index', ['category' => 'all'] + request()->query()) }}"
                            class="flex items-center justify-between px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50 rounded-xl">
                            All Categories
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('shop.products.index', ['category' => $category->id] + request()->query()) }}"
                                class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-colors duration-100">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="h-13 flex items-center gap-2 px-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50"
                        :class="open ? 'border-blue-500 text-blue-600 bg-blue-50 ring-4 ring-blue-500/10' : ''">
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
                        <a href="{{ route('shop.products.index', ['sort' => 'latest'] + request()->query()) }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors duration-100">Latest
                            Arrivals</a>
                        <a href="{{ route('shop.products.index', ['sort' => 'rating'] + request()->query()) }}"
                            class="flex items-center justify-between px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50 rounded-xl">
                            Top Rated
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </a>
                        <a href="{{ route('shop.products.index', ['sort' => 'price_asc'] + request()->query()) }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors duration-100">Price:
                            Low to High</a>
                        <a href="{{ route('shop.products.index', ['sort' => 'price_desc'] + request()->query()) }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors duration-100">Price:
                            High to Low</a>
                    </div>
                </div>

            </div>

            <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @include('shop.products.partials.products', ['products' => $products])
            </div>

            @if ($products->hasMorePages())
                <div class="text-center mt-16 mb-12">
                    <button id="load-more-btn" data-url="{{ $products->nextPageUrl() }}"
                        class="inline-flex items-center gap-2.5 px-10 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 shadow-sm transition-all duration-200 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 hover:ring-4 hover:ring-blue-500/10 active:scale-95">
                        <i class="fa-solid fa-plus text-[11px]"></i>
                        Explore More Products
                    </button>
                </div>
            @endif

            <div class="h-16"></div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
