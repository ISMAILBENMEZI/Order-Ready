<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $product->name }}</title>
    @include('layouts.head')

    @vite(['resources/js/globalUtils/notifications.js'])
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

        .thumb-active {
            border-color: #2563EB !important;
        }

        .star-filled {
            color: #FBBF24;
        }

        .star-empty {
            color: #E2E8F0;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-10">

            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Home</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <a href="{{ route('shop.products.index') }}" class="hover:text-blue-600 transition-colors">Shop</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-slate-600 truncate max-w-[200px]">{{ $product->name }}</span>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <a href="{{ url()->previous() }}">Back</a>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

                <div x-data="{ active: '{{ $product->images->first()->image_url ?? '' }}' }">

                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm mb-4 overflow-hidden">
                        <div
                            class="relative h-[420px] flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-50/30 rounded-2xl overflow-hidden">
                            <img :src="active" alt="{{ $product->name }}"
                                class="max-h-full max-w-full object-contain transition-all duration-300">
                            @if ($product->is_negotiable)
                                <span
                                    class="absolute top-4 left-4 bg-blue-600 text-white text-[10px] font-bold tracking-wider px-3 py-1.5 rounded-full shadow-lg shadow-blue-500/30">
                                    Negotiable
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-3 flex-wrap">
                        @foreach ($product->images as $image)
                            <button @click="active = '{{ $image->image_url }}'"
                                :class="active === '{{ $image->image_url }}' ?
                                    'border-blue-500 shadow-md shadow-blue-500/20 scale-105' :
                                    'border-slate-200 hover:border-blue-300'"
                                class="w-20 h-20 flex-shrink-0 bg-white rounded-2xl border-2 overflow-hidden transition-all duration-200 focus:outline-none">
                                <img src="{{ $image->image_url }}" class="w-full h-full object-contain p-2">
                            </button>
                        @endforeach
                    </div>

                </div>

                <div class="flex flex-col gap-6">

                    <div class="flex items-center flex-wrap gap-2">
                        <span
                            class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-full border border-blue-100">
                            <i class="fa-solid fa-tag text-[9px] mr-1"></i>{{ $product->category->name }}
                        </span>
                        @if ($product->is_negotiable)
                            <span
                                class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full border border-emerald-100">
                                <i class="fa-solid fa-handshake text-[9px] mr-1"></i>Negotiable
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-extrabold text-slate-900 leading-tight tracking-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-0.5">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($averageRating))
                                    <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                                @else
                                    <i class="fa-regular fa-star text-slate-200 text-sm"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm font-bold text-slate-700">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-sm text-slate-400 font-medium">
                            ({{ $product->ratings->count() }} {{ Str::plural('review', $product->ratings->count()) }})
                        </span>
                    </div>

                    <div class="border-t border-slate-100"></div>

                    <div class="flex items-end gap-3">
                        @if ($product->discount_price)
                            <span class="text-4xl font-extrabold text-blue-600 tracking-tight leading-none">
                                ${{ number_format($product->discount_price, 2) }}
                            </span>
                            <div class="flex flex-col pb-0.5">
                                <span class="text-sm font-semibold text-slate-400 line-through leading-none mb-1">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                @php
                                    $pct = round((1 - $product->discount_price / $product->price) * 100);
                                @endphp
                                <span
                                    class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                                    -{{ $pct }}% OFF
                                </span>
                            </div>
                        @else
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight leading-none">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        @endif
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Description</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4 bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                        <div
                            class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-500/30">
                            <i class="fa-solid fa-shop text-white text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Sold by</p>
                            <p class="text-sm font-bold text-slate-800 truncate">
                                {{ $product->store->name ?? 'Unknown Store' }}</p>
                        </div>
                        <a href="{{ $product->store ? route('shop.stores.show', $product->store) : '#' }}"
                            class="text-xs font-bold text-blue-600 hover:text-blue-700 flex-shrink-0 hover:underline">
                            Visit Store <i class="fa-solid fa-arrow-right text-[9px] ml-1"></i>
                        </a>
                    </div>

                    <div class="flex gap-3">
                        <button
                            class="flex-1 flex items-center justify-center gap-2.5 h-13 py-3.5 bg-slate-900 text-white rounded-2xl text-sm font-bold hover:bg-blue-600 transition-colors duration-200 active:scale-95 shadow-sm">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            Message Seller
                        </button>

                        <button x-data="{ copied: false }"
                            @click="navigator.clipboard?.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                            class="w-13 h-13 p-3.5 flex items-center justify-center bg-white border border-slate-200 rounded-2xl text-slate-500 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 active:scale-90 shadow-sm"
                            :title="copied ? 'Link copied!' : 'Share'">
                            <i class="fa-solid fa-share-nodes text-sm" x-show="!copied"></i>
                            <i class="fa-solid fa-check text-sm text-blue-600" x-show="copied"
                                style="display:none;"></i>
                        </button>

                        <div x-data="{ open:{{ request('report') ? 'true' : false }} }">
                            <button @click="open = true"
                                class="w-13 h-13 p-3.5 flex items-center justify-center bg-white border border-slate-200 rounded-2xl text-slate-400 hover:border-red-300 hover:text-red-500 hover:bg-red-50 transition-all duration-200 active:scale-95 shadow-sm"
                                title="Report">
                                <i class="fa-solid fa-flag text-sm"></i>
                            </button>

                            <div x-show="open" class="fixed inset-0 z-[100] flex items-center justify-center p-4"
                                style="display: none;">

                                <div x-show="open" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

                                <div x-show="open" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                    @click.outside="open = false"
                                    class="relative bg-white w-full max-w-md overflow-hidden rounded-[24px] shadow-2xl ring-1 ring-slate-200">

                                    <div
                                        class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                            <span
                                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                                <i class="fa-solid fa-circle-exclamation text-sm"></i>
                                            </span>
                                            Report this product
                                        </h2>
                                        <button @click="open = false"
                                            class="text-slate-400 hover:text-slate-600 transition-colors">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>

                                    <form method="POST" action="{{ route('shop.product.reports', $product) }}"
                                        class="p-6">
                                        @csrf

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block mb-1.5 text-sm font-semibold text-slate-700">Reason
                                                    for reporting</label>
                                                <div class="relative">
                                                    <select name="reason" required
                                                        class="w-full bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl focus:ring-4 focus:ring-red-50 focus:border-red-400 block p-3 appearance-none transition-all outline-none">
                                                        <option value="">Select a reason</option>
                                                        <option value="spam">Spam</option>
                                                        <option value="scam">Scam</option>
                                                        <option value="fake_product">Fake product</option>
                                                        <option value="inappropriate_content">Inappropriate content
                                                        </option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block mb-1.5 text-sm font-semibold text-slate-700">Details
                                                    (optional)</label>
                                                <textarea name="description" rows="4"
                                                    class="w-full bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl focus:ring-4 focus:ring-red-50 focus:border-red-400 block p-3 transition-all outline-none resize-none"
                                                    placeholder="Please provide more information..."></textarea>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 mt-8">
                                            <button type="button" @click="open = false"
                                                class="flex-1 px-4 py-3 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all active:scale-95">
                                                Cancel
                                            </button>

                                            <button type="submit"
                                                class="flex-[2] px-4 py-3 text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-200 rounded-xl transition-all active:scale-95">
                                                Submit Report
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sticky top-6">

                        <h2 class="text-lg font-extrabold text-slate-900 mb-6">Rating Summary</h2>

                        <div class="flex items-end gap-3 mb-5">
                            <span class="text-6xl font-extrabold text-slate-900 leading-none tracking-tight">
                                {{ number_format($averageRating, 1) }}
                            </span>
                            <div class="pb-1">
                                <div class="flex gap-0.5 mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fa-solid fa-star {{ $i <= round($averageRating) ? 'text-amber-400' : 'text-slate-200' }} text-lg"></i>
                                    @endfor
                                </div>
                                <p class="text-xs text-slate-400 font-semibold">{{ $product->ratings->count() }}
                                    reviews</p>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            @php $total = max($product->ratings->count(), 1); @endphp
                            @for ($s = 5; $s >= 1; $s--)
                                @php
                                    $count = $product->ratings->where('rating', $s)->count();
                                    $pct = round(($count / $total) * 100);
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span
                                        class="text-xs font-bold text-slate-500 w-4 text-right">{{ $s }}</span>
                                    <i class="fa-solid fa-star text-amber-400 text-xs flex-shrink-0"></i>
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full transition-all duration-500"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-semibold text-slate-400 w-7 text-right">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>

                    </div>
                </div>

                <div class="lg:col-span-2 flex flex-col gap-5" id="rating">

                    <h2 class="text-xl font-extrabold text-slate-900">Customer Reviews</h2>

                    @auth
                        <form method="POST" action="{{ route('shop.products.review', $product) }}"
                            x-data="{ rating: 5, hovering: 0 }" class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                            @csrf
                            <h3 class="text-sm font-bold text-slate-700 mb-4">Write a Review</h3>

                            <div class="flex items-center gap-1.5 mb-4">
                                <p class="text-xs font-semibold text-slate-400 mr-2">Your rating:</p>
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" @click="rating = {{ $i }}"
                                        @mouseenter="hovering = {{ $i }}" @mouseleave="hovering = 0"
                                        class="focus:outline-none">
                                        <i class="fa-solid fa-star text-xl transition-colors duration-100"
                                            :class="(hovering || rating) >= {{ $i }} ? 'text-amber-400' :
                                                'text-slate-200'"></i>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" :value="rating">
                            </div>

                            <textarea name="comment" rows="3" placeholder="Share your experience with this product..."
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-700 placeholder-slate-400 outline-none resize-none transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white mb-4"></textarea>

                            <button type="submit"
                                class="px-7 py-3 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition-colors duration-200 active:scale-95">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">Want to leave a review?</p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    <a href="{{ route('auth.login') }}"
                                        class="text-blue-600 font-bold hover:underline">Sign in</a> to share
                                    your experience.
                                </p>
                            </div>
                        </div>
                    @endauth

                    <div class="space-y-4">
                        @forelse ($product->ratings as $rating)
                            <div
                                class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 hover:border-blue-100 hover:shadow-md hover:shadow-blue-500/5 transition-all duration-200">

                                <div class="flex items-start justify-between gap-4 mb-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-500/30">
                                            <span class="text-white text-xs font-bold">
                                                {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 leading-none mb-1">
                                                {{ $rating->user->name }}</p>
                                            <p class="text-[11px] text-slate-400 font-medium">
                                                {{ $rating->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <div class="flex gap-0.5 flex-shrink-0">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fa-solid fa-star text-xs {{ $i <= $rating->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                        @endfor
                                    </div>
                                </div>

                                @if ($rating->comment)
                                    <p class="text-sm text-slate-600 leading-relaxed font-medium">
                                        {{ $rating->comment }}
                                    </p>
                                @endif

                            </div>
                        @empty
                            <div class="text-center py-14 bg-white rounded-3xl border border-slate-200">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-regular fa-star text-slate-400 text-xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-500">No reviews yet</p>
                                <p class="text-xs text-slate-400 mt-1">Be the first to share your experience</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
