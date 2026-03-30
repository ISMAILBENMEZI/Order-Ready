<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Store - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/store/myStore.js', 'resources/js/globalUtils/notifications.js'])
    <style>
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-25deg);
            transition: 0.7s;
        }

        .group:hover .shine-effect::after {
            left: 125%;
        }

        .product-card {
            transition: all 0.2s ease-out;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow pb-16">
        <div class="relative mb-16 md:mb-24">
            <div class="h-48 md:h-80 w-full overflow-hidden bg-slate-200 shadow-inner">
                @if ($store->banner_url)
                    <img src="{{ asset('storage/' . $store->banner_url) }}" class="w-full h-full object-cover"
                        alt="Store Banner">
                @else
                    <div
                        class="w-full h-full flex items-center justify-center bg-gradient-to-r from-slate-200 to-slate-300">
                        <i class="fa-regular fa-image text-slate-400 text-5xl"></i>
                    </div>
                @endif
            </div>

            <div class="max-w-7xl mx-auto px-4 md:px-8">
                <div class="relative -mt-16 md:-mt-24 flex flex-col md:flex-row items-end md:items-center gap-6">

                    <div class="relative group">
                        <div
                            class="w-32 h-32 md:w-48 md:h-48 bg-white p-1.5 rounded-3xl shadow-2xl border-4 border-white overflow-hidden">
                            @if ($store->logo_url)
                                <img src="{{ asset('storage/' . $store->logo_url) }}"
                                    class="w-full h-full object-cover rounded-2xl" alt="{{ $store->name }} Logo">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 rounded-2xl">
                                    <i class="fa-solid fa-store text-slate-200 text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('seller.store.edit') }}"
                            class="absolute -top-2 -right-2 bg-blue-600 text-white w-10 h-10 rounded-xl shadow-lg flex items-center justify-center hover:bg-blue-700 hover:scale-110 transition-all border-4 border-white active:scale-95"
                            title="Edit Store Info">
                            <i class="fa-solid fa-pen text-sm"></i>
                        </a>
                    </div>

                    <div class="flex-grow pb-2">
                        <h1 class="text-3xl md:text-5xl font-black text-gray-900 tracking-tight drop-shadow-sm">
                            {{ $store->name }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 mt-3">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-bold border border-blue-100">
                                <i class="fa-solid fa-box mr-2"></i> {{ $products->total() }} Products
                            </span>
                        </div>
                    </div>

                    <div class="pb-2 w-full md:w-auto">
                        <a href="{{ route('seller.store.create-product') }}"
                            class="flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-100 transition-all active:scale-95 group w-full">
                            <i class="fa-solid fa-plus mr-2 group-hover:rotate-90 transition-transform"></i> Add New
                            Product
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-5">
                <div>
                    <h2 class="text-2xl font-black text-gray-900">Product Management</h2>
                    <p class="text-gray-500 text-sm mt-1">Edit, update, or remove your store listings</p>
                </div>
                <div class="hidden md:block">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Live Inventory</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    <div id="product-{{ $product->id }}"
                        class="group product-card bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col">

                        <a href="{{ route('seller.store.show-product', $product->id) }}" class="shine-effect relative block overflow-hidden bg-gray-50 aspect-square">
                            <img src="{{ $product->primaryImage->image_url ?? asset('images/placeholder.jpg') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">

                            <div class="absolute top-4 right-4 z-10">
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] uppercase font-black shadow-sm tracking-wider
                                {{ $product->status == 'active' ? 'bg-green-500 text-white' : 'bg-amber-500 text-white' }}">
                                    {{ $product->status }}
                                </span>
                            </div>
                        </a>

                        <div class="p-6 flex flex-col flex-grow">
                            <h2
                                class="text-lg font-bold text-gray-800 mb-2 truncate group-hover:text-blue-600 transition-colors">
                                {{ $product->name }}
                            </h2>

                            <div class="flex flex-col mb-5">
                                @if ($product->discount_price && $product->discount_price < $product->price)
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-2xl font-black text-blue-600">${{ number_format($product->discount_price, 2) }}</span>
                                        <span
                                            class="text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                                        <span
                                            class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-black uppercase">Sale</span>
                                    </div>
                                @else
                                    <span
                                        class="text-2xl font-black text-gray-900">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="mt-auto grid grid-cols-2 gap-3 pt-5 border-t border-gray-50">
                                <a href="{{ route('seller.store.edit-product', $product->id) }}"
                                    class="flex items-center justify-center px-4 py-2.5 bg-slate-50 text-slate-700 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-pen mr-2"></i> Edit
                                </a>

                                <button onclick="deleteProduct({{ $product->id }})"
                                    class="flex items-center justify-center px-4 py-2.5 bg-slate-50 text-red-500 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-trash mr-2"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $products->links() }}
            </div>

            @if ($products->isEmpty())
                <div class="text-center py-24 bg-white rounded-[2rem] border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-box-open text-3xl text-slate-200"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Your shelf is empty</h3>
                    <p class="text-gray-500 mt-2 max-w-xs mx-auto text-sm">Start growing your business by adding your
                        first product today.</p>
                    <a href="{{ route('seller.store.create-product') }}"
                        class="inline-block mt-6 text-blue-600 font-bold hover:underline">
                        Click here to begin &rarr;
                    </a>
                </div>
            @endif
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>

