<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $store->name }}</title>
    @include('layouts.head')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow">

        <div class="w-full">

            <div class="relative h-40 sm:h-56 md:h-64 w-full overflow-hidden bg-slate-200">
                @if ($store->banner_url)
                    <img src="{{ asset('storage/' . $store->banner_url) }}" class="w-full h-full object-cover"
                        alt="Store Banner">
                @else
                    <div
                        class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-store text-white/10 text-8xl"></i>
                    </div>
                @endif
                <div
                    class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-100 to-transparent pointer-events-none">
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm -mt-8 sm:-mt-10 relative z-10 p-4 sm:p-6">

                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">

                        <div class="flex-shrink-0 -mt-10 sm:-mt-14">
                            <div
                                class="w-20 h-20 sm:w-28 sm:h-28 rounded-2xl bg-white border-4 border-white shadow-lg overflow-hidden">
                                @if ($store->logo_url)
                                    <img src="{{ asset('storage/' . $store->logo_url) }}"
                                        class="w-full h-full object-cover" alt="{{ $store->name }}">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100">
                                        <i class="fa-solid fa-store text-blue-300 text-2xl sm:text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 pt-1">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                                <div class="min-w-0">
                                    <h1
                                        class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight truncate">
                                        {{ $store->name }}
                                    </h1>
                                    @if ($store->description)
                                        <p class="text-sm text-slate-500 mt-1 font-medium line-clamp-2 max-w-lg">
                                            {{ $store->description }}
                                        </p>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-3 mt-3">
                                        @if ($store->location)
                                            <span
                                                class="flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                                                <i class="fa-solid fa-location-dot text-blue-400 text-[11px]"></i>
                                                {{ $store->location }}
                                            </span>
                                        @endif
                                        @if ($store->contact_email)
                                            <span
                                                class="flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                                                <i class="fa-solid fa-envelope text-blue-400 text-[11px]"></i>
                                                {{ $store->contact_email }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <button x-data="{ copied: false }"
                                        @click="navigator.clipboard?.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 3000)"
                                        class="flex items-center gap-1.5 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 active:scale-95">
                                        <i class="fa-solid fa-link text-[11px]" x-show="!copied"></i>
                                        <i class="fa-solid fa-check text-[11px] text-blue-600" x-show="copied"
                                            style="display:none;"></i>
                                        <span x-text="copied ? 'Copied!' : 'Share'"
                                            class="hidden sm:inline">Share</span>
                                    </button>

                                    @auth
                                        <form action="{{ route('shop.stores.follow', $store->slug) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-1.5 px-4 py-2 rounded-xl font-bold text-xs transition-all duration-200
                                            {{ auth()->user()->followedStores->contains($store->id)
                                                ? 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-red-50 hover:text-red-500 hover:border-red-200'
                                                : 'bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/25' }}">
                                                @if (auth()->user()->followedStores->contains($store->id))
                                                    <i class="fa-solid fa-user-check text-[11px]"></i>
                                                    <span class="hidden sm:inline">Following</span>
                                                @else
                                                    <i class="fa-solid fa-user-plus text-[11px]"></i>
                                                    <span class="hidden sm:inline">Follow</span>
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('auth.login') }}"
                                            class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/25">
                                            <i class="fa-solid fa-user-plus text-[11px]"></i>
                                            <span class="hidden sm:inline">Follow</span>
                                        </a>
                                    @endauth
                                </div>

                            </div>

                            <div class="flex flex-wrap items-center gap-4 mt-4 pt-4 border-t border-slate-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
                                        <i class="fa-solid fa-box text-blue-500 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-900 leading-none">
                                            {{ $products->total() }}</p>
                                        <p class="text-[10px] font-semibold text-slate-400 leading-none mt-0.5">Products
                                        </p>
                                    </div>
                                </div>

                                <div class="w-px h-8 bg-slate-100"></div>

                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-pink-50 flex items-center justify-center">
                                        <i class="fa-solid fa-heart text-pink-400 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-900 leading-none">
                                            {{ $store->followers_count ?? $store->followers()->count() }}
                                        </p>
                                        <p class="text-[10px] font-semibold text-slate-400 leading-none mt-0.5">
                                            Followers</p>
                                    </div>
                                </div>

                                @if ($store->created_at)
                                    <div class="w-px h-8 bg-slate-100"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center">
                                            <i class="fa-solid fa-calendar text-emerald-500 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-extrabold text-slate-900 leading-none">
                                                {{ $store->created_at->format('M Y') }}
                                            </p>
                                            <p class="text-[10px] font-semibold text-slate-400 leading-none mt-0.5">
                                                Member since</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-8 mt-6">
            <form method="GET" action="{{ request()->url() }}" class="flex flex-col sm:flex-row gap-3">

                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search products in this store..."
                        class="w-full h-12 pl-11 pr-4 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder-slate-400 outline-none shadow-sm transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                </div>

                <div x-data="{ open: false }" class="relative flex-shrink-0">
                    <button type="button" @click="open = !open"
                        :class="open ? 'border-blue-500 text-blue-600 bg-blue-50 ring-4 ring-blue-500/10' :
                            'border-slate-200 text-slate-700'"
                        class="h-12 w-full sm:w-auto flex items-center justify-between gap-2 px-5 bg-white border rounded-2xl text-sm font-semibold shadow-sm transition-all duration-200 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 min-w-[150px]">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-blue-500 text-xs"></i>
                            {{ request('category')
                                ? $categories->firstWhere('id', request('category'))?->name ?? 'All Categories'
                                : 'All Categories' }}
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0" style="display:none;"
                        class="absolute z-50 mt-2 left-0 sm:right-0 sm:left-auto w-full sm:w-56 bg-white border border-slate-200 rounded-2xl shadow-xl p-2">
                        <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}"
                            class="flex items-center justify-between px-4 py-2.5 text-sm rounded-xl transition-colors {{ !request('category') ? 'font-bold text-blue-600 bg-blue-50' : 'font-medium text-slate-600 hover:bg-slate-50' }}">
                            All Categories
                            @if (!request('category'))
                                <i class="fa-solid fa-check text-[10px]"></i>
                            @endif
                        </a>
                        @foreach ($categories ?? [] as $category)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $category->id, 'page' => null]) }}"
                                class="flex items-center justify-between px-4 py-2.5 text-sm rounded-xl transition-colors 
               {{ request('category') == $category->id ? 'font-bold text-blue-600 bg-blue-50' : 'font-medium text-slate-600 hover:bg-slate-50' }}">
                                {{ $category->name }}
                                @if (request('category') == $category->id)
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative flex-shrink-0">
                    <button type="button" @click="open = !open"
                        :class="open ? 'border-blue-500 text-blue-600 bg-blue-50 ring-4 ring-blue-500/10' :
                            'border-slate-200 text-slate-700'"
                        class="h-12 w-full sm:w-auto flex items-center justify-between gap-2 px-5 bg-white border rounded-2xl text-sm font-semibold shadow-sm transition-all duration-200 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 min-w-[140px]">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-arrow-up-wide-short text-blue-500 text-xs"></i>
                            Sort By
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0" style="display:none;"
                        class="absolute z-50 mt-2 right-0 w-52 bg-white border border-slate-200 rounded-2xl shadow-xl p-2">
                        @foreach (['latest' => 'Latest Arrivals', 'price_asc' => 'Price: Low to High', 'price_desc' => 'Price: High to Low', 'top_rated' => 'Top Rated'] as $val => $label)
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $val, 'page' => null]) }}"
                                class="flex items-center justify-between px-4 py-2.5 text-sm rounded-xl transition-colors {{ request('sort', 'latest') === $val ? 'font-bold text-blue-600 bg-blue-50' : 'font-medium text-slate-600 hover:bg-slate-50' }}">
                                {{ $label }}
                                @if (request('sort', 'latest') === $val)
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="hidden"></button>

            </form>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-8 mt-6 mb-16">

            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-extrabold text-slate-900">
                    @if (request('search'))
                        Results for "{{ request('search') }}"
                    @else
                        All Products
                    @endif
                </h2>
                <span class="text-xs font-semibold text-slate-400">{{ $products->total() }} total</span>
            </div>

            @if ($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5">
                    @foreach ($products as $product)
                        <div
                            class="group bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col shadow-sm hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-200 transition-all duration-300">

                            <div
                                class="relative h-36 sm:h-52 bg-gradient-to-br from-slate-50 to-blue-50/40 flex items-center justify-center overflow-hidden">
                                <a href="{{ route('shop.products.show', $product) }}"
                                    class="flex items-center justify-center w-full h-full">
                                    <img src="{{ $product->primaryImage->image_url ?? '' }}"
                                        alt="{{ $product->name }}" loading="lazy"
                                        class="max-h-[80%] max-w-[85%] object-contain transition-transform duration-500 group-hover:scale-105">
                                </a>

                                @if ($product->is_negotiable)
                                    <span
                                        class="absolute bottom-2 left-2 bg-blue-600 text-white text-[9px] sm:text-[10px] font-bold tracking-wide px-2 py-1 rounded-full">
                                        Negotiable
                                    </span>
                                @endif

                                <div x-data="{ open: false }" class="absolute top-2 right-2"
                                    :class="open ? 'z-50' : 'z-10'">
                                    <button @click.prevent.stop="open = !open" @click.outside="open = false"
                                        class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-white/90 backdrop-blur-sm border border-slate-200 rounded-full text-slate-500 hover:border-blue-400 hover:text-blue-600 hover:bg-white transition-all duration-150">
                                        <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                    </button>

                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100" style="display:none;"
                                        class="absolute top-9 right-0 w-40 bg-white border border-slate-200 rounded-2xl shadow-xl z-[100] overflow-hidden p-1.5">

                                        <a href="#"
                                            class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                            <i class="fa-solid fa-bookmark text-indigo-400 w-3.5 text-center"></i>
                                            Favorite
                                        </a>
                                        <a href="{{ route('shop.products.show', $product) }}#rating"
                                            class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                            <i class="fa-solid fa-star text-amber-400 w-3.5 text-center"></i> Rating
                                        </a>
                                        <a href="#"
                                            class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                            <i class="fa-solid fa-flag text-red-400 w-3.5 text-center"></i> Report
                                        </a>
                                        <a href="#"
                                            class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                            <i class="fa-solid fa-heart text-pink-400 w-3.5 text-center"></i> Interest
                                        </a>
                                        <button type="button" x-data="{ copied: false }"
                                            @click.stop="navigator.clipboard?.writeText('{{ route('shop.products.show', $product->slug) }}'); copied = true; setTimeout(() => copied = false, 3000)"
                                            class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                            <i class="fa-solid fa-share-nodes text-emerald-400 w-3.5 text-center"
                                                x-show="!copied"></i>
                                            <i class="fa-solid fa-check text-emerald-500 w-3.5 text-center"
                                                x-show="copied" style="display:none;"></i>
                                            <span x-text="copied ? 'Copied!' : 'Share'">Share</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 sm:p-5 flex flex-col flex-grow">

                                <a href="{{ route('shop.products.show', $product) }}"
                                    class="block text-sm sm:text-base font-bold text-slate-900 truncate mb-1 sm:mb-1.5 group-hover:text-blue-600 transition-colors duration-150">
                                    {{ $product->name }}
                                </a>

                                <p
                                    class="text-[12px] sm:text-[13px] text-slate-400 font-normal leading-relaxed line-clamp-2 flex-grow mb-3 sm:mb-4 hidden sm:block">
                                    {{ $product->description }}
                                </p>

                                <div class="flex items-center gap-1.5 sm:gap-2 mb-3 sm:mb-4">
                                    @if ($product->discount_price)
                                        <span class="text-base sm:text-xl font-extrabold text-blue-600 tracking-tight">
                                            ${{ number_format($product->discount_price, 2) }}
                                        </span>
                                        <span class="text-xs sm:text-sm font-semibold text-slate-300 line-through">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @else
                                        <span
                                            class="text-base sm:text-xl font-extrabold text-slate-900 tracking-tight">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 mt-auto">
                                    <button
                                        class="flex-1 flex items-center justify-center gap-1.5 sm:gap-2 h-9 sm:h-11 bg-slate-900 text-white text-[11px] sm:text-xs font-bold rounded-xl hover:bg-blue-600 transition-colors duration-200 active:scale-95">
                                        <i class="fa-solid fa-paper-plane text-[10px] sm:text-[11px]"></i>
                                        Message
                                    </button>
                                    <button
                                        class="w-9 h-9 sm:w-11 sm:h-11 flex items-center justify-center border border-slate-200 text-slate-300 rounded-xl hover:bg-pink-50 hover:text-pink-500 hover:border-pink-200 transition-all duration-200 active:scale-90">
                                        <i class="fa-solid fa-heart text-[12px] sm:text-[14px]"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-box-open text-blue-400 text-2xl"></i>
                    </div>
                    @if (request('search'))
                        <p class="text-sm font-bold text-slate-600 mb-1">No results found</p>
                        <p class="text-xs text-slate-400 font-medium">Try a different search term or clear the filters.
                        </p>
                        <a href="{{ request()->url() }}"
                            class="mt-4 px-5 py-2.5 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-colors active:scale-95">
                            Clear Search
                        </a>
                    @else
                        <p class="text-sm font-bold text-slate-600 mb-1">No products yet</p>
                        <p class="text-xs text-slate-400 font-medium">This store hasn't added any products yet.</p>
                    @endif
                </div>
            @endif

            <div class="mt-10">
                {{ $products->links() }}
            </div>

        </div>

    </main>

    @include('layouts.footer')

</body>

</html>
