<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $store->name }} — Dormant Products</title>
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
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dead Products <span
                        class="text-slate-400 text-lg ml-2 font-bold">#NoEngagement</span></h1>
                <p class="text-slate-400 text-xs mt-1 font-medium">Products with zero favorites or interest requests.</p>
            </div>

            <div class="bg-white border border-slate-200 px-5 py-3 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center">
                    <i class="fa-solid fa-box-open text-slate-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Dormant Count</p>
                    <p class="text-xl font-black text-slate-900 leading-none">{{ $products->count() }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($products as $product)
                <div
                    class="bg-white rounded-3xl border border-slate-200 p-5 flex flex-col items-center text-center shadow-sm hover:border-indigo-200 transition-all group">

                    <div class="relative mb-4">
                        <div
                            class="w-24 h-24 rounded-full overflow-hidden bg-slate-50 border-4 border-white shadow-inner grayscale group-hover:grayscale-0 transition-all">
                            <img src="{{ $product->primaryImage->image_url ?? asset('images/default.png') }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-8 h-8 bg-slate-100 text-slate-400 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fa-solid fa-ghost text-xs"></i>
                        </div>
                    </div>

                    <div class="w-full">
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">
                            ID: #{{ $product->id }}
                        </p>
                        <h3 class="text-sm font-extrabold text-slate-700 truncate mb-2">
                            {{ $product->name }}
                        </h3>

                        <div class="bg-slate-50 rounded-xl py-2 px-3 inline-block">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Inactive Status</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-50 w-full flex justify-between items-center">
                        <span class="text-xs font-black text-slate-900">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('seller.store.edit-product', $product) }}"
                            class="flex items-center justify-center gap-2 py-2.5 px-4 bg-white border border-slate-200 text-slate-700 text-[11px] font-black uppercase tracking-wider rounded-2xl shadow-sm hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 active:scale-95 group">
                            <i
                                class="fa-solid fa-pen-to-square text-[12px] text-slate-400 group-hover:text-blue-500"></i>
                            Edit Product
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <div
                        class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-fire-flame-curved text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Amazing! All products have
                        active engagement.</p>
                </div>
            @endforelse
        </div>

    </main>

    @include('layouts.footer')
</body>

</html>
