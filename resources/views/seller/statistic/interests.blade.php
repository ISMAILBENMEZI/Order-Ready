<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $store->name }} — Customer Interests</title>
    @include('layouts.head')
</head>

<body class="bg-[#fcfcfd] min-h-screen antialiased">
    @include('layouts.header')

    <main class="max-w-7xl mx-auto px-6 py-12">

        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="{{ url()->previous() }}"
                    class="text-slate-400 hover:text-slate-900 transition-colors flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Statistics Overview
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Top Interests <span
                        class="text-rose-600 text-lg ml-2 font-bold">#Ranking</span></h1>
            </div>

            <div class="bg-white border border-slate-200 px-5 py-3 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-rose-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Total Interests</p>
                    <p class="text-xl font-black text-slate-900 leading-none">{{ $products->sum('interests_count') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($products as $index => $product)
                <div
                    class="bg-white rounded-3xl border border-slate-200 p-4 flex items-center gap-4 shadow-sm hover:border-rose-200 transition-colors">

                    <div class="relative flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100">
                            <img src="{{ $product->primaryImage->image_url ?? asset('images/default.png') }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -top-2 -left-2 w-6 h-6 bg-slate-900 text-white rounded-lg flex items-center justify-center text-[10px] font-black shadow-lg">
                            {{ $index + 1 }}
                        </div>
                    </div>

                    <div class="flex-grow min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5 truncate">
                            ID: #{{ $product->id }} • {{ $product->category->name ?? 'General' }}
                        </p>
                        <h3 class="text-sm font-extrabold text-slate-800 truncate mb-1">
                            {{ $product->name }}
                        </h3>
                        <p class="text-xs font-bold text-slate-400">
                            Price: <span class="text-slate-900">${{ number_format($product->price, 2) }}</span>
                        </p>
                    </div>

                    <div class="text-center border-l border-slate-100 pl-4 py-1">
                        <p class="text-[18px] font-black text-rose-600 leading-none mb-1">
                            {{ $product->interests_count }}
                        </p>
                        <div class="flex items-center justify-center gap-1 text-rose-300">
                            <i class="fa-solid fa-star text-[8px]"></i> <span
                                class="text-[8px] font-black uppercase tracking-tighter">Interests</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No interests recorded yet</p>
                </div>
            @endforelse
        </div>

    </main>

    @include('layouts.footer')
</body>

</html>
