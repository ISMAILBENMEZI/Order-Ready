<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Store — Product Management</title>
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
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow">

        <div class="relative">

            <div class="h-52 md:h-72 w-full overflow-hidden bg-slate-200">
                @if ($store->banner_url)
                    <img src="{{ asset('storage/' . $store->banner_url) }}" class="w-full h-full object-cover"
                        alt="Store Banner">
                @else
                    <div
                        class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 flex items-center justify-center">
                        <i class="fa-regular fa-image text-white/20 text-7xl"></i>
                    </div>
                @endif
                <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-100 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-5 sm:px-8">
                <div class="relative -mt-14 flex flex-col sm:flex-row items-start sm:items-end gap-5 mb-0">

                    <div class="relative flex-shrink-0">
                        <div
                            class="w-28 h-28 md:w-36 md:h-36 bg-white rounded-3xl shadow-xl border-4 border-white overflow-hidden">
                            @if ($store->logo_url)
                                <img src="{{ asset('storage/' . $store->logo_url) }}" class="w-full h-full object-cover"
                                    alt="Logo">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100">
                                    <i class="fa-solid fa-store text-blue-300 text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('seller.store.edit') }}"
                            class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/40 border-2 border-white hover:bg-blue-700 transition-colors"
                            title="Edit Store">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                    </div>

                    <div class="flex-1 pb-1 min-w-0">
                        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 tracking-tight truncate">
                            {{ $store->name }}
                        </h1>
                        @if ($store->description)
                            <p class="text-sm text-slate-500 mt-1 font-medium line-clamp-1">{{ $store->description }}</p>
                        @endif
                    </div>

                    <div class="flex-shrink-0 pb-1 w-full sm:w-auto flex items-center gap-3">
                        <a href="{{ route('seller.store.statistics',$store) }}"
                            class="flex items-center justify-center gap-2.5 px-6 py-3.5 bg-white text-slate-700 text-sm font-bold rounded-2xl hover:bg-slate-50 transition-colors shadow-sm border border-slate-200 active:scale-95 w-full sm:w-auto">
                            <i class="fa-solid fa-chart-line text-blue-500 text-xs"></i>
                            Statistics
                        </a>
                        <a href="{{ route('seller.store.create-product') }}"
                            class="flex items-center justify-center gap-2.5 px-6 py-3.5 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30 active:scale-95 w-full sm:w-auto">
                            <i class="fa-solid fa-plus text-xs"></i>
                            Add New Product
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-5 sm:px-8 mt-10">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-extrabold text-slate-900">Your Products</h2>
                <span class="text-xs font-semibold text-slate-400">{{ $products->total() }} total</span>
            </div>

            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach ($products as $product)
                        @php
                            $statusConfig = [
                                'available' => [
                                    'label' => 'Available',
                                    'dot' => 'bg-emerald-500',
                                    'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                ],
                                'negotiating' => [
                                    'label' => 'Negotiating',
                                    'dot' => 'bg-blue-500',
                                    'badge' => 'bg-blue-50 text-blue-700 border-blue-100',
                                ],
                                'sold_out' => [
                                    'label' => 'Sold Out',
                                    'dot' => 'bg-red-500',
                                    'badge' => 'bg-red-50 text-red-600 border-red-100',
                                ],
                            ];
                            $sc = $statusConfig[$product->status] ?? $statusConfig['available'];
                        @endphp

                        <div id="product-{{ $product->id }}"
                            class="group bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col shadow-sm hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-500/8 hover:border-blue-200 transition-all duration-200">

                            <div
                                class="relative bg-gradient-to-br from-slate-50 to-blue-50/30 aspect-square overflow-hidden">

                                <a href="{{ route('seller.store.show-product', $product->id) }}"
                                    class="block w-full h-full flex items-center justify-center p-4">
                                    <img src="{{ $product->primaryImage->image_url ?? asset('images/placeholder.jpg') }}"
                                        alt="{{ $product->name }}" loading="lazy"
                                        class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                                </a>

                                <div x-data="{ open: false }" class="absolute top-3 left-3 z-20">
                                    <button @click.prevent.stop="open = !open" type="button"
                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-[10px] font-bold border {{ $sc['badge'] }} shadow-sm backdrop-blur-sm transition-all hover:shadow-md">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }} {{ $product->status === 'negotiating' ? 'animate-pulse' : '' }}"></span>
                                        {{ $sc['label'] }}
                                        <i class="fa-solid fa-chevron-down text-[8px] opacity-60"
                                            :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;"></i>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100" style="display:none;"
                                        class="absolute top-9 left-0 w-48 bg-white rounded-2xl shadow-xl border border-slate-200 p-1.5 z-50">
                                        @foreach (['available' => ['label' => 'Available in stock', 'dot' => 'bg-emerald-500'], 'negotiating' => ['label' => 'Negotiating', 'dot' => 'bg-blue-500'], 'sold_out' => ['label' => 'Sold Out', 'dot' => 'bg-red-500']] as $key => $val)
                                            <form
                                                action="{{ route('seller.store.product.update-status', $product) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ $key }}">
                                                <button type="submit"
                                                    class="w-full text-left px-3 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center gap-3 rounded-xl transition-colors {{ $product->status === $key ? 'bg-slate-50 font-bold' : '' }}">
                                                    <span
                                                        class="w-2 h-2 rounded-full {{ $val['dot'] }} flex-shrink-0"></span>
                                                    {{ $val['label'] }}
                                                    @if ($product->status === $key)
                                                        <i
                                                            class="fa-solid fa-check text-blue-600 text-[10px] ml-auto"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($product->discount_price && $product->discount_price < $product->price)
                                    @php $pct = round((1 - $product->discount_price / $product->price) * 100); @endphp
                                    <span
                                        class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                        -{{ $pct }}%
                                    </span>
                                @endif

                            </div>

                            <div class="p-4 flex flex-col flex-grow">

                                <a href="{{ route('seller.store.show-product', $product->id) }}"
                                    class="text-sm font-bold text-slate-800 truncate mb-1 hover:text-blue-600 transition-colors block">
                                    {{ $product->name }}
                                </a>

                                <div class="flex items-center gap-2 mb-4">
                                    @if ($product->discount_price && $product->discount_price < $product->price)
                                        <span class="text-lg font-extrabold text-blue-600 tracking-tight">
                                            ${{ number_format($product->discount_price, 2) }}
                                        </span>
                                        <span class="text-xs font-semibold text-slate-300 line-through">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-lg font-extrabold text-slate-900 tracking-tight">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-auto grid grid-cols-2 gap-2 pt-4 border-t border-slate-100">
                                    <a href="{{ route('seller.store.edit-product', $product) }}"
                                        class="flex items-center justify-center gap-1.5 py-2.5 bg-slate-50 text-slate-600 text-xs font-bold rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-200 active:scale-95">
                                        <i class="fa-solid fa-pen text-[10px]"></i> Edit
                                    </a>

                                    <form action="{{ route('seller.store.delete-product', $product) }}"
                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full flex items-center justify-center gap-1.5 py-2.5 bg-slate-50 text-red-400 text-xs font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200 active:scale-95">
                                            <i class="fa-solid fa-trash text-[10px]"></i> Delete
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl border border-slate-200 shadow-sm">
                    <div class="w-20 h-20 rounded-3xl bg-blue-50 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-box-open text-blue-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-800 mb-2">No Products Yet</h3>
                    <p class="text-sm text-slate-400 font-medium mb-6">Start by adding your first product to your store.</p>
                    <a href="{{ route('seller.store.create-product') }}"
                        class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/25 active:scale-95">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Add First Product
                    </a>
                </div>
            @endif

            <div class="mt-10 mb-16 flex items-center justify-center gap-1">
                {{-- Previous --}}
                @if ($products->onFirstPage())
                    <span class="px-4 py-2.5 text-sm font-semibold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                        class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="px-4 py-2.5 text-sm font-bold text-white bg-blue-600 border border-blue-600 rounded-xl shadow-md shadow-blue-500/25">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 active:scale-95">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                        class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                @else
                    <span class="px-4 py-2.5 text-sm font-semibold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </span>
                @endif
            </div>

        </div>
    </main>

    @include('layouts.footer')

</body>

</html>