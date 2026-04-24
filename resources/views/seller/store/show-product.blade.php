<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $product->name }} - Details</title>
    @include('layouts.head')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    @include('layouts.header')

    <main class="flex-grow py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <a href="{{ route('seller.store.index') }}"
                    class="flex items-center text-slate-500 hover:text-blue-600 transition-all font-bold text-sm uppercase tracking-widest group">
                    <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i> Back to
                    Store
                </a>
                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-50">
                    <div class="flex-grow">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter
            {{ $product->status == 'approved'
                ? 'bg-emerald-50 text-emerald-600 border border-emerald-100'
                : ($product->status == 'pending'
                    ? 'bg-amber-50 text-amber-600 border border-amber-100'
                    : 'bg-rose-50 text-rose-600 border border-rose-100') }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full animate-pulse {{ $product->status == 'approved' ? 'bg-emerald-500' : ($product->status == 'pending' ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                            {{ $product->status }}
                        </span>
                    </div>

                    <a href="{{ route('seller.store.edit-product', $product) }}"
                        class="group flex items-center justify-center w-9 h-9 bg-white border border-slate-200 text-slate-400 rounded-xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-300 shadow-sm active:scale-90"
                        title="Edit Product">
                        <i class="fa-solid fa-pen-to-square text-xs group-hover:shake transition-transform"></i>
                    </a>

                    <form action="{{ route('seller.store.delete-product', $product) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this product?')" class="inline-block">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="group flex items-center justify-center w-9 h-9 bg-white border border-slate-200 text-slate-400 rounded-xl hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all duration-300 shadow-sm active:scale-90"
                            title="Delete Product">
                            <i class="fa-solid fa-trash-can text-xs group-hover:shake transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div
                class="bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12">

                    <div class="lg:col-span-5 p-8 bg-slate-50/50 border-r border-slate-50">
                        <div class="sticky top-8">
                            <div
                                class="aspect-square rounded-[2.5rem] overflow-hidden bg-white border border-slate-200 shadow-sm relative group">
                                @php
                                    $primaryImage =
                                        $product->images->where('is_primary', true)->first() ??
                                        $product->images->first();
                                @endphp
                                <img id="main-display-image"
                                    src="{{ Storage::url($product->primaryImage->image_url) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain bg-white transition-transform duration-700">

                                @if ($product->discount_price)
                                    <div
                                        class="absolute top-6 left-6 px-4 py-2 bg-emerald-500 text-white text-[10px] font-black rounded-full shadow-xl uppercase">
                                        Save
                                        {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </div>
                                @endif
                            </div>

                            @if ($product->images->count() > 1)
                                <div class="flex gap-4 mt-6 overflow-x-auto pb-2 scrollbar-hide">
                                    @foreach ($product->images as $image)
                                        <button onclick="changeMainImage('{{ Storage::url($image->image_url) }}', this)"
                                            class="thumbnail-btn flex-shrink-0 w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all {{ $image->is_primary ? 'border-blue-500 shadow-md' : 'border-white hover:border-blue-200' }}">
                                            <img src="{{ Storage::url($image->image_url) }}" class="w-full h-full object-contain">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="lg:col-span-7 p-10 md:p-16 flex flex-col justify-center">
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-6">
                                @if ($product->category)
                                    <span
                                        class="px-4 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.15em] rounded-full border border-blue-100">
                                        <i class="fa-solid fa-tag mr-1.5"></i> {{ $product->category->name }}
                                    </span>
                                @endif
                                @if ($product->is_negotiable)
                                    <span
                                        class="px-4 py-1.5 bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-[0.15em] rounded-full">
                                        <i class="fa-solid fa-comments mr-1.5"></i> Negotiable
                                    </span>
                                @endif
                            </div>

                            <h1 class="text-5xl font-black text-slate-900 tracking-tighter mb-6 leading-tight">
                                {{ $product->name }}
                            </h1>

                            <div class="prose prose-slate">
                                <p class="text-slate-500 text-lg leading-relaxed font-medium">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-8 rounded-[2rem] mb-10 border border-slate-100">
                            <span
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Current
                                Pricing</span>
                            <div class="flex items-center gap-4">
                                @if ($product->discount_price)
                                    <div class="text-5xl font-black text-blue-600 tracking-tighter">
                                        ${{ number_format($product->discount_price, 2) }}
                                    </div>
                                    <div class="text-2xl font-bold text-slate-300 line-through">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                @else
                                    <div class="text-5xl font-black text-slate-900 tracking-tighter">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center shadow-sm">

                                    <i
                                        class="fa-solid {{ $product->is_negotiable ? 'fa-comments-dollar text-blue-500' : 'fa-hand-holding-dollar text-slate-400' }}"></i>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Price Status
                                    </span>
                                    <span
                                        class="text-sm font-bold {{ $product->is_negotiable ? 'text-blue-600' : 'text-slate-700' }}">
                                        {{ $product->is_negotiable ? 'Negotiable' : 'Fixed Price' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-calendar-check text-blue-500"></i>
                                </div>
                                <div>
                                    <span
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Listed
                                        Date</span>
                                    <span
                                        class="text-sm font-bold text-slate-700">{{ $product->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    @include('layouts.footer')

    <script>
        function changeMainImage(src, btn) {
            const mainImg = document.getElementById('main-display-image');
            mainImg.style.opacity = '0';

            setTimeout(() => {
                mainImg.src = src;
                mainImg.style.opacity = '1';
            }, 200);

            document.querySelectorAll('.thumbnail-btn').forEach(b => {
                b.classList.remove('border-blue-500', 'shadow-md');
                b.classList.add('border-white');
            });
            btn.classList.remove('border-white');
            btn.classList.add('border-blue-500', 'shadow-md');
        }
    </script>
</body>

</html>
